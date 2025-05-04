<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendVerificationCode']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
Route::post('/validate-reset-code', [ResetPasswordController::class, 'validateResetCode']);
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::get('/availability', [ReservationController::class, 'checkAvailability']);