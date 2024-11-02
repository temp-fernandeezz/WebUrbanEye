<?php

use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationSearch;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------|
| API Routes                                                               |
|--------------------------------------------------------------------------|
|                                                                          |
| Here is where you can register API routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will       |
| be assigned to the "api" middleware group. Make something great!         |
|                                                                          |
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::post('/user/change-password', [AuthController::class, 'changePassword']);
    Route::post('/user/upload-image', [AuthController::class, 'uploadImage']);
    Route::get('/user', [AuthController::class, 'getUserInfo']);
});

Route::get('/location/search', [LocationSearch::class, 'search']);

Route::get('/locations/approved', [ReportController::class, 'getApprovedLocations']);
Route::get('/reports/approved-locations', [ReportController::class, 'getApprovedLocations']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/reports', [ReportController::class, 'store']);
    Route::get('/user-notifications', [NotificationController::class, 'getUserNotifications']);
    Route::post('/notifications/confirm/{id}', [NotificationController::class, 'confirmNotification']);
    Route::post('/notifications/delete/{id}', [NotificationController::class, 'deleteNotification']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/user/upload-image', [AuthController::class, 'uploadImage']);
Route::post('/register', [AuthController::class, 'register']);
