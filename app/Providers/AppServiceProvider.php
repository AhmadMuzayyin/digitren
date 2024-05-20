<?php

namespace App\Providers;

use App\Models\Santri;
use App\Models\TransaksiTabungan;
use App\Observers\SantriObserver;
use App\Observers\TransaksiTabunganObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Santri::observe(SantriObserver::class);
        TransaksiTabungan::observe(TransaksiTabunganObserver::class);
    }
}
