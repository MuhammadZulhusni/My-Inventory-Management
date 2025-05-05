<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\AdminController;

Route::get('/', function () {
    return view('auth.login');
});

// Admin dashboard route requiring authentication and username verification
// Returns the 'admin.index' view and is named 'dashboard'
Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grouped routes for 'AdminController.php'
Route::controller(AdminController::class)->group(function(){
    // Route to display the admin profile page
    // URL: 'admin/profile'
    // Calls the 'AdminProfile' method in AdminController
    Route::get('admin/profile', 'AdminProfile')->name('admin.profile');

    Route::post('admin/update-profile', [AdminController::class, 'UpdateAdminProfile'])->name('admin.update.profile');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
