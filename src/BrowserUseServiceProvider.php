<?php

namespace BrowserUseLaravel;

use BrowserUseLaravel\Commands\BrowserUseCostCommand;
use Illuminate\Support\ServiceProvider;

class BrowserUseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/browser-use.php',
            'browser-use'
        );

        $this->app->singleton(BrowserUseClient::class, function ($app) {
            return new BrowserUseClient(
                apiKey: config('browser-use.api_key'),
                baseUrl: config('browser-use.base_url'),
                timeout: config('browser-use.timeout'),
                retryTimes: config('browser-use.retry.times'),
                retrySleep: config('browser-use.retry.sleep'),
            );
        });

        $this->app->alias(BrowserUseClient::class, 'browser-use');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BrowserUseCostCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/browser-use.php' => config_path('browser-use.php'),
        ], 'browser-use-config');
    }
}
