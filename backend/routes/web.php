<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// FIXME: tambah middleware ['auth', 'role:admin'] saat auth + PastikanRole tersedia di branch
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/indikator', [App\Http\Controllers\AdminController::class, 'indikator'])->name('indikator.index');
    Route::get('/pengguna', [App\Http\Controllers\AdminController::class, 'pengguna'])->name('pengguna.index');
    Route::post('/pengguna', [App\Http\Controllers\AdminController::class, 'storePengguna'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [App\Http\Controllers\AdminController::class, 'updatePengguna'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [App\Http\Controllers\AdminController::class, 'deletePengguna'])->name('pengguna.delete');
    Route::post('/pengguna/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'togglePenggunaStatus'])->name('pengguna.toggle-status');
});
