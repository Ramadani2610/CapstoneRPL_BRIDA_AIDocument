<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
| Routes in this file are prefixed with /api by Laravel.
|
| Status codes used consistently:
|   200 OK · 201 Created · 202 Accepted (queued)
|   204 No Content · 401 Not logged in · 403 Wrong role
|   404 Not found · 409 Conflict · 422 Validation failed
|   501 Placeholder (not implemented yet)
*/

// Rate limited: 5 attempts per minute
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('auth.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});
