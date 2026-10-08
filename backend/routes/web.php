<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifikatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verifikator/dashboard', [VerifikatorController::class, 'dashboard'])
    ->name('verifikator.dashboard');

Route::get('/verifikator/antrian-review', [VerifikatorController::class, 'antrianReview'])
    ->name('verifikator.antrian-review');

Route::get('/verifikator/riwayat-audit', [VerifikatorController::class, 'riwayatAudit'])
    ->name('verifikator.riwayat-audit');