<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kelas\KelasController;
use App\Http\Controllers\Santri\SantriController;
use App\Http\Controllers\Tabungan\SaldoDebitController;
use App\Http\Controllers\Tingkatan\TingkatanController;
use App\Http\Controllers\Transaksi\TransaksiController;
use App\Http\Controllers\Sinkronisasi\SinkronisasiController;

Route::get('set_theme', function (Illuminate\Http\Request $request) {
    if ($request['newTheme'] == 'light-theme') {
        session(['theme' => 'light-theme']);

        return response()->json(['light'], 200);
    } else {
        session(['theme' => 'dark-theme']);

        return response()->json(['dark'], 200);
    }
});
Route::get('/', function () {
    return redirect('login');
});
Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('auth', [AuthController::class, 'auth'])->name('login.auth')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('tingkatan', [TingkatanController::class, 'index'])->name('tingkatan.index');

    // kelas
    Route::controller(KelasController::class)->as('kelas.')->group(function () {
        Route::get('/kelas', 'index')->name('index');
        Route::get('/kelas/{id}', 'show')->name('show');
        Route::post('/kelas', 'store')->name('store');
        Route::patch('/kelas/update/{kelas}', 'update')->name('update');
        Route::delete('/kelas/destroy/{kelas}', 'destroy')->name('destroy');
    });

    // santri dan kelas santri
    Route::controller(SantriController::class)->as('santri.')->group(function () {
        Route::get('/santri', 'index')->name('index');
        Route::post('/santri', 'store')->name('store');
        Route::get('/santri/show/{santri}', 'show')->name('show');
        Route::patch('/santri/update/{santri}', 'update')->name('update');
        Route::delete('/santri/destroy/{santri}', 'destroy')->name('destroy');
    });

    // saldo debit tabungan santri
    Route::controller(SaldoDebitController::class)->as('saldo_debit.')->group(function () {
        Route::get('tabungan', 'index')->name('index');
        Route::post('tabungan', 'store')->name('store');
        Route::delete('tabungan/{tabungan}/destroy', 'destroy')->name('destroy');
    });

    // transaksi tabungan (saldo debit)
    Route::controller(TransaksiController::class)->as('transaksi.')->group(function () {
        Route::get('/transaksi', 'index')->name('index');
        Route::post('/transaksi', 'store')->name('store');
        Route::patch('/transaksi/update', 'update')->name('update');
    });

    // sinkronisasi data lokal dengan data di cloud
    Route::controller(SinkronisasiController::class)->as('sinkronisasi.')->group(function () {
        Route::get('/sinkronisasi', 'index')->name('index');
        Route::post('/sinkronisasi', 'store')->name('store');
        Route::patch('/sinkronisasi/update', 'update')->name('update');
    });
});
