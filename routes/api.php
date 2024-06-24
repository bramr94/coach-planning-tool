<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\CoachController;
use App\Http\Controllers\Api\MeController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthenticationController::class, 'login'])
    ->name('api.login');

Route::middleware('auth:sanctum')
    ->name('api.')
    ->group(function () {
        Route::get('/me', MeController::class)
            ->name('me');

        Route::resource('coaches', CoachController::class)
            ->only(['index', 'show']);

        Route::resource('appointments', AppointmentController::class)
            ->only(['store']);

        Route::post('/logout', [AuthenticationController::class, 'logout'])
            ->name('logout');
    });
