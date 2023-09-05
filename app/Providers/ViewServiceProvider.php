<?php

namespace App\Providers;

use App\Models\Kamar;
use App\Models\Kelas;
use Illuminate\Support\ServiceProvider;

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
        view()->composer('pages.santri.index', function ($view) {
            $kelas = Kelas::all();
            $view->with('kelas', $kelas);

            $kamar = Kamar::all();
            $view->with('kamar', $kamar);
        });
    }
}
