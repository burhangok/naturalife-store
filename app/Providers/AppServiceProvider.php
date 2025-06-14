<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $allowedIPs = array_map('trim', explode(',', config('app.debug_allowed_ips')));

        $allowedIPs = array_filter($allowedIPs);

        if (empty($allowedIPs)) {
            return;
        }

        if (in_array(Request::ip(), $allowedIPs)) {
            Debugbar::enable();
        } else {
            Debugbar::disable();
        }
        $this->app->singleton(
            \App\Services\AffiliateTrackingService::class,
            \App\Services\AffiliateTrackingService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

// Production'da HTTPS zorla
if (config('app.env') === 'production') {
    URL::forceScheme('https');
}

// Mixed content için
if (request()->isSecure()) {
    URL::forceScheme('https');
}

        ParallelTesting::setUpTestDatabase(function (string $database, int $token) {
            Artisan::call('db:seed');
        });

    }
}
