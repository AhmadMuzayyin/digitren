<?php

use App\Http\Controllers\Api\synchronizationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function () {
    Route::controller(synchronizationController::class)->group(function () {
        // sync kelas
        Route::get('/sync/kelas', 'get_kelas')->name('get.kelas');
        Route::post('/sync/kelas', 'store_kelas')->name('store.kelas');

        // sync santri
        Route::get('/sync/santri', 'get_santri')->name('get.santri');
        Route::post('/sync/santri', 'store_santri')->name('store.santri');

        // sync tabungan
        Route::get('/sync/tabungan', 'get_tabungan')->name('get.tabungan');
        Route::post('/sync/tabungan', 'store_tabungan')->name('store.tabungan');

        // sync transaksi
        Route::get('/sync/transaksi', 'get_transaksi')->name('get.transaksi');
        Route::post('/sync/transaksi', 'store_transaksi')->name('store.transaksi');
    });
});
