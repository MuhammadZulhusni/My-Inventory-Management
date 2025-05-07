<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\ItemController;

// Public route: Show login page
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard (authenticated users only)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

// Admin-specific routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Admin Profile
    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/update-profile', [AdminController::class, 'updateProfile'])->name('admin.update.profile');

    // Item Management
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('admin.items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('admin.items.update'); 
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
});

// Laravel Breeze profile management
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
