<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kamar\KamarController;
use App\Http\Controllers\Kelas\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\Santri\SantriController;
use App\Http\Controllers\Riwayat\RiwayatController;
use App\Http\Controllers\Rapor\RaportSantriController;
use App\Http\Controllers\Tabungan\SaldoDebitController;
use App\Http\Controllers\Tingkatan\TingkatanController;
use App\Http\Controllers\Transaksi\TransaksiController;
use App\Http\Controllers\Sinkronisasi\SinkronisasiController;
use App\Models\Kamar;

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


    Route::middleware(['auth', 'Administrator'])->prefix('admin')->group(function () {
        Route::get('tingkatan', [TingkatanController::class, 'index'])->name('tingkatan.index');

        // kamar
        Route::controller(KamarController::class)->as('kamar.')->group(function () {
            Route::get('/kamar', 'index')->name('index');
            Route::get('/kamar/{id}', 'show')->name('show');
            Route::post('/kamar', 'store')->name('store');
            Route::patch('/kamar/update/{kamar}', 'update')->name('update');
            Route::delete('/kamar/destroy/{kamar}', 'destroy')->name('destroy');
        });
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
            // Route::get('/santri/show/{santri}', 'show')->name('show');
            Route::patch('/santri/update/{santri}', 'update')->name('update');
            Route::delete('/santri/destroy/{santri}', 'destroy')->name('destroy');
            Route::get('print/kts/{santri:no_induk}', 'print_kts')->name('print.kts');
        });

        // mapel
        Route::controller(MapelController::class)->as('mapel.')->group(function () {
            Route::get('/mapel', 'index')->name('index');
            Route::post('/mapel/store', 'store')->name('store');
            Route::patch('/mapel/{santri}/update', 'update')->name('update');
            Route::delete('/mapel/{santri}/destroy', 'destroy')->name('destroy');
        });
        // rapor santri
        Route::controller(RaportSantriController::class)->as('rapor.')->group(function () {
            Route::get('/rapor', 'index')->name('index');
            Route::get('/rapor/santri/{kelas}', 'santri')->name('santri');
            Route::get('/rapor/nilai/{santri}', 'nilai')->name('nilai');
        });

        // riwayat
        Route::controller(RiwayatController::class)->as('riwayat.')->group(function () {
            Route::get('/riwayat', 'index')->name('index');
        });

        // sinkronisasi data lokal dengan data di cloud
        Route::controller(SinkronisasiController::class)->as('sinkronisasi.')->group(function () {
            Route::get('/sinkronisasi', 'index')->name('index');
            Route::post('/sinkronisasi', 'store')->name('store');
            Route::patch('/sinkronisasi/update', 'update')->name('update');
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
    });

    Route::middleware(['auth', 'Keuangan'])->prefix('keuangan')->group(function () {
        // saldo debit tabungan santri
        Route::controller(SaldoDebitController::class)->as('keuangan.saldo_debit.')->group(function () {
            Route::get('tabungan', 'index')->name('index');
            Route::post('tabungan', 'store')->name('store');
            Route::delete('tabungan/{tabungan}/destroy', 'destroy')->name('destroy');
        });

        // transaksi tabungan (saldo debit)
        Route::controller(TransaksiController::class)->as('keuangan.transaksi.')->group(function () {
            Route::get('/transaksi', 'index')->name('index');
            Route::post('/transaksi', 'store')->name('store');
            Route::patch('/transaksi/update', 'update')->name('update');
        });
    });
});
