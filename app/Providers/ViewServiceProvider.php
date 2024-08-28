<?php

namespace App\Providers;

use App\Models\JenisSurat;
use App\Models\Kabupaten;
use App\Models\Kamar;
use App\Models\Kecamatan;
use App\Models\Kelas;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Santri;
use App\Models\Setting;
use App\Models\WhatsappMessage;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('pages.santri.*', function ($view) {
            $kelas = Kelas::all();
            $view->with('classes', $kelas);
            $kamar = Kamar::all();
            $view->with('badroom', $kamar);
            $provinsi = Provinsi::all();
            $view->with('provinsi', $provinsi);
            // $kabupaten = Kabupaten::all();
            // $view->with('kabupaten', $kabupaten);
            // $kecamatan = Kecamatan::all();
            // $view->with('kecamatan', $kecamatan);
            // $kelurahan = Kelurahan::all();
            // $view->with('kelurahan', $kelurahan);
        });
        view()->composer('pages.users.index', function ($view) {
            $roles = Role::all();
            $view->with('roles', $roles);
        });
        view()->composer('pages.transfer.*', function ($view) {
            $santris = Santri::whereHas('tabungan')->get();
            $view->with('santris', $santris);
        });
        view()->composer('pages.mapel.index', function ($view) {
            $kelas = Kelas::all();
            $view->with('kelas', $kelas);
        });
        view()->composer('pages.profil.*', function ($view) {
            $provinsi = Provinsi::all();
            $view->with('provinsi', $provinsi);
        });
        view()->composer('pages.users.*', function ($view) {
            $roles = Role::all();
            $view->with('roles', $roles);
        });
        view()->composer('pages.saldo_debit.*', function ($view) {
            $santri = Santri::all();
            $view->with('santri', $santri);
        });
        view()->composer('layouts.*', function ($view) {
            $setting = Setting::first();
            $view->with('setting', $setting);
        });
    }
}
