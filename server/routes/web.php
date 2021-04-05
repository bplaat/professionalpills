<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalsController;
use App\Http\Controllers\HospitalUsersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TrailsController;
use App\Http\Controllers\TrailUsersController;
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
    // Hospital routes
    Route::get('/hospitals', [HospitalsController::class, 'index'])->name('hospitals.index');
    Route::get('/hospitals/{hospital}/edit', [HospitalsController::class, 'edit'])
        ->name('hospitals.edit')->middleware('can:update,hospital');
    Route::get('/hospitals/{hospital}/delete', [HospitalsController::class, 'delete'])
        ->name('hospitals.delete')->middleware('can:delete,hospital');
    Route::get('/hospitals/{hospital}', [HospitalsController::class, 'show'])->name('hospitals.show');
    Route::post('/hospitals/{hospital}', [HospitalsController::class, 'update'])
        ->name('hospitals.update')->middleware('can:update,hospital');

    // Hospital user routes
    Route::post('/hospitals/{hospital}/users', [HospitalUsersController::class, 'store'])
        ->name('hospitals.users.create')->middleware('can:create_hospital_user,hospital');
    Route::post('/hospitals/{hospital}/users/{user}/update', [HospitalUsersController::class, 'update'])
        ->name('hospitals.users.update')->middleware('can:update_hospital_user,hospital');
    Route::get('/hospitals/{hospital}/users/{user}/delete', [HospitalUsersController::class, 'delete'])
        ->name('hospitals.users.delete')->middleware('can:delete_hospital_user,hospital');

    // Trail routes
    Route::get('/trails', [TrailsController::class, 'index'])->name('trails.index');
    Route::view('/trails/create', 'trails.create')->name('trails.create');
    Route::post('/trails', [TrailsController::class, 'store'])->name('trails.store');
    Route::get('/trails/{trail}/run', [TrailsController::class, 'run'])
        ->name('trails.run')->middleware('can:run,trail');
    Route::get('/trails/{trail}/edit', [TrailsController::class, 'edit'])
        ->name('trails.edit')->middleware('can:update,trail');
    Route::get('/trails/{trail}/delete', [TrailsController::class, 'delete'])
        ->name('trails.delete')->middleware('can:delete,trail');
    Route::get('/trails/{trail}', [TrailsController::class, 'show'])->name('trails.show');
    Route::post('/trails/{trail}', [TrailsController::class, 'update'])
        ->name('trails.update')->middleware('can:update,trail');

    // Trail user routes
    Route::post('/trails/{trail}/users', [TrailUsersController::class, 'store'])
        ->name('trails.users.create')->middleware('can:create_trail_user,trail');
    Route::get('/trails/{trail}/users/{user}/delete', [TrailUsersController::class, 'delete'])
        ->name('trails.users.delete')->middleware('can:delete_trail_user,trail');

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
