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
     * Displays the admin profile view.
     * Retrieves the currently authenticated admin's data using their ID and passes it to the view.
     */
    public function AdminProfile()
    {
        $id = Auth::user()->id;                                                                 // Get the authenticated user's ID
        $adminData = User::findOrFail($id);                                                 // Retrieve the admin's data from the database

        return view('admin.admin_profile_view', compact('adminData'));    // Return the profile view with admin data
    }

    public function UpdateAdminProfile(Request $request)
{
    $id = Auth::user()->id;
    $admin = User::findOrFail($id);

    $admin->name = $request->name;
    $admin->email = $request->email;

    if ($request->hasFile('photo')) {
        // Delete old photo if exists
        $oldPhotoPath = public_path('uploads/admin_profiles/' . $admin->photo);
        if (file_exists($oldPhotoPath) && $admin->photo != 'no_image.png') {
            @unlink($oldPhotoPath);
        }

        // Save new photo
        $file = $request->file('photo');
        $filename = date('YmdHi') . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/admin_profiles'), $filename);
        $admin->photo = $filename;
    }

    $admin->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

}
