<?php

namespace N11Api\N11SpApi;

use Illuminate\Support\ServiceProvider;

class N11SpApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/n11-sp-api.php' => config_path('n11-sp-api.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Config dosyasını merger
        $this->mergeConfigFrom(__DIR__ . '/../config/n11-sp-api.php', 'n11-sp-api');

        // N11Api singleton olarak kayıt
        $this->app->singleton('n11-sp-api', function () {
            return new N11Api(
                config('n11-sp-api.app_key'),
                config('n11-sp-api.app_secret'),
                config('n11-sp-api.base_url')
            );
        });

        // N11Api class bağımlılığını çözümle
        $this->app->bind(N11Api::class, function ($app) {
            return $app->make('n11-sp-api');
        });
    }
} 