<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminHospitalsController;
use App\Http\Controllers\Admin\AdminHospitalUsersController;
use App\Http\Controllers\Admin\AdminTrailsController;
use App\Http\Controllers\Admin\AdminTrailUsersController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Home page
Route::view('/', 'home')->name('home');

// Normal routes
Route::middleware('auth')->group(function () {
    // Settings routes
    Route::view('/settings', 'settings')->name('settings');
    Route::post('/settings/change_details', [SettingsController::class, 'changeDetails'])->name('settings.change_details');
    Route::post('/settings/change_password', [SettingsController::class, 'changePassword'])->name('settings.change_password');

    // Auth routes
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Admin routes
Route::middleware('admin')->group(function () {
    // Admin home page
    Route::view('/admin', 'admin.home')->name('admin.home');

    // Admin users routes
    Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::view('/admin/users/create', 'admin.users.create')->name('admin.users.create');
    Route::post('/admin/users', [AdminUsersController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/hijack', [AdminUsersController::class, 'hijack'])->name('admin.users.hijack');
    Route::get('/admin/users/{user}/edit', [AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('/admin/users/{user}/delete', [AdminUsersController::class, 'delete'])->name('admin.users.delete');
    Route::get('/admin/users/{user}', [AdminUsersController::class, 'show'])->name('admin.users.show');
    Route::post('/admin/users/{user}', [AdminUsersController::class, 'update'])->name('admin.users.update');

    // Admin hospital routes
    Route::get('/admin/hospitals', [AdminHospitalsController::class, 'index'])->name('admin.hospitals.index');
    Route::view('/admin/hospitals/create', 'admin.hospitals.create')->name('admin.hospitals.create');
    Route::post('/admin/hospitals', [AdminHospitalsController::class, 'store'])->name('admin.hospitals.store');
    Route::get('/admin/hospitals/{hospital}/edit', [AdminHospitalsController::class, 'edit'])->name('admin.hospitals.edit');
    Route::get('/admin/hospitals/{hospital}/delete', [AdminHospitalsController::class, 'delete'])->name('admin.hospitals.delete');
    Route::get('/admin/hospitals/{hospital}', [AdminHospitalsController::class, 'show'])->name('admin.hospitals.show');
    Route::post('/admin/hospitals/{hospital}', [AdminHospitalsController::class, 'update'])->name('admin.hospitals.update');

    // Admin hospital user routes
    Route::post('/admin/hospitals/{hospital}/users', [AdminHospitalUsersController::class, 'store'])->name('admin.hospitals.users.create');
    Route::post('/admin/hospitals/{hospital}/users/{user}/update', [AdminHospitalUsersController::class, 'update'])->name('admin.hospitals.users.update');
    Route::get('/admin/hospitals/{hospital}/users/{user}/delete', [AdminHospitalUsersController::class, 'delete'])->name('admin.hospitals.users.delete');

    // Admin trail routes
    Route::get('/admin/trails', [AdminTrailsController::class, 'index'])->name('admin.trails.index');
    Route::get('/admin/trails/create', [AdminTrailsController::class, 'create'])->name('admin.trails.create');
    Route::post('/admin/trails', [AdminTrailsController::class, 'store'])->name('admin.trails.store');
    Route::get('/admin/trails/{trail}/run', [AdminTrailsController::class, 'run'])->name('admin.trails.run');
    Route::get('/admin/trails/{trail}/edit', [AdminTrailsController::class, 'edit'])->name('admin.trails.edit');
    Route::get('/admin/trails/{trail}/delete', [AdminTrailsController::class, 'delete'])->name('admin.trails.delete');
    Route::get('/admin/trails/{trail}', [AdminTrailsController::class, 'show'])->name('admin.trails.show');
    Route::post('/admin/trails/{trail}', [AdminTrailsController::class, 'update'])->name('admin.trails.update');

    // Admin trail user routes
    Route::post('/admin/trails/{trail}/users', [AdminTrailUsersController::class, 'store'])->name('admin.trails.users.create');
    Route::get('/admin/trails/{trail}/users/{user}/delete', [AdminTrailUsersController::class, 'delete'])->name('admin.trails.users.delete');

});

// Guest routes
Route::middleware('guest')->group(function () {
    // Auth routes
    Route::view('/auth/login', 'auth.login')->name('auth.login');
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::view('/auth/register', 'auth.register')->name('auth.register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});
