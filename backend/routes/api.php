<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndicatorPublicController;
use App\Http\Controllers\SubmissionController;
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

    // Read by every logged-in role
    Route::get('/indikators', [IndicatorPublicController::class, 'index'])->name('indikators.index');
    Route::get('/predikat', [IndicatorPublicController::class, 'predikat'])->name('predikat.index');

    Route::middleware('role:inovator')->group(function () {
        Route::get('/dashboard/inovator', [SubmissionController::class, 'dashboard'])->name('inovator.dashboard');

        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
        Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
        Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');

        // {indicator} is the indicator KODE (21..44), not the id
        Route::get('/submissions/{submission}/parameters', [SubmissionController::class, 'parameters'])->name('submissions.parameters');
        Route::put('/submissions/{submission}/parameters/{indicator}', [SubmissionController::class, 'simpanParameter'])->name('submissions.parameters.simpan');
    });
});
