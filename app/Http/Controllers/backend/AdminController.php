<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin profile page
     */
    public function AdminProfile()
    {
        $adminData = Auth::user(); // Get authenticated user
        return view('admin.admin_profile_view', compact('adminData'));
    }

    /**
     * Handle admin profile update
     */
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());
    
        // Custom validation messages
        $customMessages = [
            'photo.image' => 'The file must be an image.',
            'photo.mimes' => 'Only JPEG, PNG, and JPG files are allowed.',
            'photo.max' => 'The photo size must be less than 2MB.',
        ];

        // Validation
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], $customMessages);
    
        // Basic fields update
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Handle photo
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($user->photo && $user->photo != 'no_image.png') {
                $oldPath = public_path('uploads/admin_profiles/' . $user->photo);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }
    
            // Save the new photo
            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin_profiles'), $filename);
            $user->photo = $filename;
        }
    
        // Password update (optional)
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }
    
            $request->validate([
                'new_password' => 'required|min:6|same:confirm_password',
            ]);
    
            $user->password = Hash::make($request->new_password);
        }
    
        // Save the changes
        $user->save();
    
        return back()->with('success', 'Profile updated successfully.');
    }    
}
