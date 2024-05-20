<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Kamar\KamarController;
use App\Http\Controllers\Kelas\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Rapor\RaportSantriController;
use App\Http\Controllers\Riwayat\RiwayatController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Santri\SantriController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Sinkron\SinkronController;
use App\Http\Controllers\Surat\JenisSuratController;
use App\Http\Controllers\Surat\SuratController;
use App\Http\Controllers\Tabungan\SaldoDebitController;
use App\Http\Controllers\Transaksi\TransaksiController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;

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
    Route::controller(ProfilController::class)->as('profil.')->group(function () {
        Route::get('/profil/{user}', 'show')->name('show');
        Route::post('/profil/account/{user}', 'account')->name('account');
        Route::post('/profil/biodata/{user}', 'biodata')->name('biodata');
    });
    Route::group(['middleware' => ['role:Administrator|Pengurus']], function () {
        // kamar
        Route::controller(KamarController::class)->as('kamar.')->group(function () {
            Route::get('/kamar', 'index')->name('index');
            // Route::get('/kamar/{id}', 'show')->name('show');
            Route::post('/kamar', 'store')->name('store');
            Route::patch('/kamar/update/{kamar}', 'update')->name('update');
            Route::delete('/kamar/destroy/{kamar}', 'destroy')->name('destroy');
            Route::get('/kamar/download', 'download')->name('download');
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
            Route::get('/santri/{santri}/show', 'show')->name('show');
            Route::post('/santri', 'store')->name('store');
            Route::get('/santri/download', 'download')->name('download');
            Route::post('/santri/import', 'import')->name('import');
            Route::post('/santri/export', 'export')->name('export');
            Route::get('/santri/{santri}/edit', 'edit')->name('edit');
            Route::patch('/santri/update/{santri}', 'update')->name('update');
            Route::delete('/santri/destroy/{santri}', 'destroy')->name('destroy');
            Route::get('print/kts/{santri:no_induk}', 'print_kts')->name('print.kts');
        });
        Route::controller(SinkronController::class)->as('sync.')->group(function () {
            Route::get('/sinkron', 'index')->name('index');
            Route::get('/sheet/get/data', 'sync')->name('sync');
            Route::post('/update/modules', 'update')->name('update');
        });
    });

    Route::group(['middleware' => ['role:Administrator']], function () {
        // roles
        Route::controller(RoleController::class)->as('roles.')->group(function () {
            Route::get('/roles', 'index')->name('index');
            Route::post('/roles', 'store')->name('store');
            Route::patch('/roles/{role}/update', 'update')->name('update');
            Route::delete('/roles/{role}/destroy', 'destroy')->name('destroy');
        });
        // users
        Route::controller(UsersController::class)->as('users.')->group(function () {
            Route::get('/users', 'index')->name('index');
            Route::post('/users', 'store')->name('store');
            Route::patch('/users/{user}/update', 'update')->name('update');
            Route::delete('/users/{user}/destroy', 'destroy')->name('destroy');
        });
        // riwayat
        Route::controller(RiwayatController::class)->as('riwayat.')->group(function () {
            Route::get('/riwayat', 'index')->name('index');
        });
        // setting
        Route::controller(SettingController::class)->as('setting.')->group(function () {
            Route::get('setting', 'index')->name('index');
            Route::post('setting/store', 'store')->name('store');
            Route::patch('setting/{setting}/update', 'update')->name('update');
            Route::post('setting/whatsapp', 'whatsapp')->name('whatsapp');
        });
    });

    Route::group(['middleware' => ['role:Administrator|Keuangan']], function () {
        // saldo debit tabungan santri
        Route::controller(SaldoDebitController::class)->as('saldo_debit.')->group(function () {
            Route::get('tabungan', 'index')->name('index');
            Route::post('tabungan', 'store')->name('store');
            Route::get('tabungan/history/{id}', 'show')->name('history');
            Route::delete('tabungan/{tabungan}/destroy', 'destroy')->name('destroy');
            Route::post('tabungan/{id}/export', 'export')->name('export');
        });
        // transaksi tabungan (saldo debit)
        Route::controller(TransaksiController::class)->as('transaksi.')->group(function () {
            Route::get('/transaksi', 'index')->name('index');
            Route::post('/transaksi', 'store')->name('store');
            Route::patch('/transaksi/update', 'update')->name('update');
        });
    });
    Route::controller(AlamatController::class)->as('alamat.')->group(function () {
        Route::get('/kabupaten', 'kabupaten')->name('kabupaten');
        Route::get('/kecamatan', 'kecamatan')->name('kecamatan');
        Route::get('/kelurahan', 'kelurahan')->name('kelurahan');
    });
});
