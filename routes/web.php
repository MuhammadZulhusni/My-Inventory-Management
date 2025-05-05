<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\AdminController;

Route::get('/', function () {
    return view('auth.login');
});

// Admin dashboard (requires authentication and email verification)
Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin profile routes
Route::middleware(['auth'])->group(function () {
    // View admin profile
    Route::get('admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

    // Update profile and optionally change password
    Route::post('admin/update-profile', [AdminController::class, 'updateProfile'])->name('admin.update.profile');

    // Optional: profile routes from Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
