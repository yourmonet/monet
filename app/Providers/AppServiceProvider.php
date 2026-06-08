<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\PembayaranKas;
use App\Observers\PembayaranKasObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PembayaranKas::observe(PembayaranKasObserver::class);
    }
}
