<?php

use App\Http\Controllers\AuthController;
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
});

Route::group(['middleware' => 'auth:api'], function () {
    // Auth routes
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getUser']);

    // Dashboard routes
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('dashboard/applications-trend', [DashboardController::class, 'applicationsTrend']);
    Route::get('dashboard/applications-status', [DashboardController::class, 'applicationsStatus']);
    Route::get('dashboard/monthly-applications', [DashboardController::class, 'monthlyApplications']);
    Route::get('dashboard/recent-activity', [DashboardController::class, 'recentActivity']);

    // Application routes
    Route::apiResource('applications', ApplicationController::class);

    // Student routes
    Route::get('students', [StudentController::class, 'index']);
    Route::get('students/{id}', [StudentController::class, 'show']);

    // BDM Officer routes
    Route::get('bdm-officers', [BdmOfficerController::class, 'index']);
    Route::get('bdm-officers/{id}', [BdmOfficerController::class, 'show']);

    // Course routes
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);

    // School routes
    Route::get('schools', [SchoolController::class, 'index']);
    Route::get('schools/{id}', [SchoolController::class, 'show']);
});
