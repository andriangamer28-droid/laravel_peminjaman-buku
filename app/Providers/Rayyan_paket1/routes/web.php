<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;

// Halaman utama yang menampilkan tabel
Route::get('/', [AlatController::class, 'index'])->name('alat.index');

// Grup rute untuk manajemen alat
Route::prefix('alat')->name('alat.')->group(function () {
    Route::get('/tambah', [AlatController::class, 'create'])->name('create');
    Route::post('/simpan', [AlatController::class, 'store'])->name('store');
    

// Gunakan group agar lebih rapi
Route::prefix('alat')->name('alat.')->group(function () {
    Route::get('/', [AlatController::class, 'index'])->name('index');
    Route::get('/tambah', [AlatController::class, 'create'])->name('create');
    Route::post('/simpan', [AlatController::class, 'store'])->name('store');
});
});