<?php

use App\Http\Controllers\VerifikatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verifikator/dashboard', [VerifikatorController::class, 'dashboard'])
    ->name('verifikator.dashboard');

Route::get('/verifikator/antrian-review', [VerifikatorController::class, 'antrianReview'])
    ->name('verifikator.antrian-review');

Route::get('/verifikator/riwayat-audit', [VerifikatorController::class, 'riwayatAudit'])
    ->name('verifikator.riwayat-audit');
