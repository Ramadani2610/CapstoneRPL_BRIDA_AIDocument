<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifikatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verifikator/riwayat', [VerifikatorController::class, 'riwayat'])
    ->name('verifikator.riwayat');

