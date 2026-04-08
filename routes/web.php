<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard for all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard'); // No permission middleware to avoid 403

    // Admin-only page
    Route::get('/admin-dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin') // Only admin can access
        ->name('admin.dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users routes (Admin/Subadmin)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}/toggle', [UserController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    // Trash routes
    Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force', [UserController::class, 'forceDelete'])->name('users.forceDelete');
});

require __DIR__ . '/auth.php';