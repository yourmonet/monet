<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\Auth\OtpPasswordResetController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::get('verify-email', [OtpVerificationController::class, 'notice'])
    ->name('verification.notice');

Route::post('verify-email', [OtpVerificationController::class, 'verify'])
    ->name('verification.verify.otp');

Route::post('email/verification-notification', [OtpVerificationController::class, 'resend'])
    ->middleware('throttle:6,1')
    ->name('verification.send.otp');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [OtpPasswordResetController::class, 'request'])
        ->name('password.request');

    Route::post('forgot-password', [OtpPasswordResetController::class, 'sendCode'])
        ->name('password.email');

    Route::get('forgot-password/verify-otp', [OtpPasswordResetController::class, 'showVerifyOtpForm'])
        ->name('password.verify_otp.form');

    Route::post('forgot-password/verify-otp', [OtpPasswordResetController::class, 'verifyOtp'])
        ->name('password.verify_otp');

    Route::get('reset-password', [OtpPasswordResetController::class, 'showResetForm'])
        ->name('password.reset.form');

    Route::post('reset-password', [OtpPasswordResetController::class, 'reset'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
