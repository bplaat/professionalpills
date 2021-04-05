<?php

use App\Http\Controllers\Api\ApiHospitalsController;
use App\Http\Controllers\Api\ApiHospitalTrailsController;
use App\Http\Controllers\Api\ApiHospitalUsersController;
use App\Http\Controllers\Api\ApiTrailsController;
use App\Http\Controllers\Api\ApiTrailUsersController;
use Illuminate\Support\Facades\Route;

// %BUG: Lekker onbeveiligd zoals het hoort

// API routes
Route::get('', function () {
    return [
        'message' => 'ProfessionalPills API documentation: https://bit.ly/3kKfgzH'
    ];
})->name('api');

// Hospital routes
Route::get('hospitals', [ApiHospitalsController::class, 'index'])->name('api.hospitals.index');
Route::get('hospitals/{hospital}', [ApiHospitalsController::class, 'show'])->name('api.hospitals.show');

// Hospital trails routes
Route::get('hospitals/{hospital}/trails', [ApiHospitalTrailsController::class, 'index'])->name('api.hospitals.trails.index');
Route::get('hospitals/{hospital}/trails/{trail}', [ApiHospitalTrailsController::class, 'show'])->name('api.hospitals.trails.show');

// Hospital users routes
Route::get('hospitals/{hospital}/users', [ApiHospitalUsersController::class, 'index'])->name('api.hospitals.users.index');
Route::get('hospitals/{hospital}/users/{user}', [ApiHospitalUsersController::class, 'show'])->name('api.hospitals.users.show');

// Trail routes
Route::get('trails', [ApiTrailsController::class, 'index'])->name('api.trails.index');
Route::get('trails/{trail}', [ApiTrailsController::class, 'show'])->name('api.trails.show');

// Trail users routes
Route::get('trails/{trail}/users', [ApiTrailUsersController::class, 'index'])->name('api.trails.users.index');
Route::post('trails/{trail}/users', [ApiTrailUsersController::class, 'store'])->name('api.trails.users.store');
Route::get('trails/{trail}/users/{user}/delete', [ApiTrailUsersController::class, 'delete'])->name('api.trails.users.delete');
