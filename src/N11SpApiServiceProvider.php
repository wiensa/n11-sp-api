<?php

namespace N11Api\N11SpApi;

use Illuminate\Support\ServiceProvider;
use N11Api\N11SpApi\Services\N11Client;

class N11SpApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/n11-sp-api.php' => config_path('n11-sp-api.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        // Config dosyasını merger
        $this->mergeConfigFrom(__DIR__ . '/../config/n11-sp-api.php', 'n11-sp-api');

        // N11Client singleton olarak kayıt
        $this->app->singleton('n11-sp-api', function () {
            return new N11Client(
                config('n11-sp-api.app_key'),
                config('n11-sp-api.app_secret'),
                config('n11-sp-api.base_url')
            );
        });

        // N11Client class bağımlılığını çözümle
        $this->app->bind(N11Client::class, function ($app) {
            return $app->make('n11-sp-api');
        });
    }
} 