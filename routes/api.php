<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'logout']);
        Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
        Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1']);
    });
    Route::middleware('guest')->group(function () {
        Route::post('/forgot-password', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'sendForgotPasswordLink'])->name('password.email');
        Route::post('/reset-password', [\App\Http\Controllers\Auth\EmailAndPasswordAuthController::class, 'resetPassword'])->name('password.reset');
    });
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ProfileController::class, 'getProfile']);
        Route::put('/', [\App\Http\Controllers\User\ProfileController::class, 'updateProfile']);
        Route::post('/avatar', [\App\Http\Controllers\User\ProfileController::class, 'updateAvatar']);
    });
    Route::prefix('user')->group(function () {
        Route::post('/follow', [\App\Http\Controllers\User\UserController::class, 'follow']);
        Route::post('/unfollow', [\App\Http\Controllers\User\UserController::class, 'unfollow']);
        Route::get('/followers', [\App\Http\Controllers\User\UserController::class, 'followers']);
        Route::get('/following', [\App\Http\Controllers\User\UserController::class, 'following']);
        Route::apiResource('/discussion', \App\Http\Controllers\Discussion\UserDiscussionController::class);
    });
    Route::prefix ('discussion')->group(function (){
        Route::get('/', [\App\Http\Controllers\Discussion\DiscussionController::class, 'index']);
        Route::post('/{discussion}/comment', [\App\Http\Controllers\Discussion\DiscussionController::class, 'comment']);
        Route::post('/{discussion}/vote',[ \App\Http\Controllers\Discussion\DiscussionController::class, 'vote']);
        Route::post('{discussion}/comment/{comment}/reply', [\App\Http\Controllers\Discussion\DiscussionController::class, 'reply']);
    });
});

