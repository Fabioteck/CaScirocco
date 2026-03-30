<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }
        // Forza URL radice e schema HTTPS in base a APP_URL
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');

    }
}
