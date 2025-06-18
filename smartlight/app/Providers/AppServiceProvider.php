<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Set default timezone to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        
        // Ensure PHP timezone also set to Jakarta
        if (config('app.timezone') === 'Asia/Jakarta') {
            date_default_timezone_set('Asia/Jakarta');
        }
    }
}
