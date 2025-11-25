<?php

use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BdmOfficerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SchoolController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('otp', [AuthController::class, 'sendOtp']);
    Route::post('reset-password', [AuthController::class, 'restPassword']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
});

// Course routes
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{id}', [CourseController::class, 'show']);

// School routes
Route::get('schools', [SchoolController::class, 'index']);
Route::get('schools/{id}', [SchoolController::class, 'show']);

// Country routes
Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{id}', [CountryController::class, 'show']);

Route::group(['middleware' => 'auth:api'], function () {
    // Auth routes
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getUser']);

    // Application routes
    Route::apiResource('applications', ApplicationController::class);

    // BDM Officer routes
    Route::get('bdm-officers', [BdmOfficerController::class, 'index']);
    Route::get('bdm-officers/{id}', [BdmOfficerController::class, 'show']);

    // Dashboard routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/stats', [DashboardController::class, 'stats']);
        Route::get('/applications-trend', [DashboardController::class, 'applicationsTrend']);
        Route::get('/applications-status', [DashboardController::class, 'applicationsStatus']);
        Route::get('/monthly-applications', [DashboardController::class, 'monthlyApplications']);
        Route::get('/recent-activity', [DashboardController::class, 'recentActivity']);
        Route::get('/country-distribution', [DashboardController::class, 'countryDistribution']);
    });

    // Student routes
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::get('/{id}', [StudentController::class, 'show']);
        Route::post('/', [StudentController::class, 'store']);
        Route::post('/validate', [StudentController::class, 'validateStudent']);
        Route::patch('/{id}', [StudentController::class, 'update']);
    });

    // Admin routes
    Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index']);
        Route::apiResource('applications', AdminApplicationController::class)->names([
            'index' => 'admin.applications.index',
            'show' => 'admin.applications.show',
            'store' => 'admin.applications.store',
            'update' => 'admin.applications.update',
            'destroy' => 'admin.applications.destroy',
        ]);
    });
});
