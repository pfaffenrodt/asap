<?php

namespace App\Providers;

use App\Integrations\CacheIntegration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        collect(Config::get('app.integrations'))->each(function($integrationConfig) {
            $this->app->singleton('integration.'.$integrationConfig['type'], function($app) use ($integrationConfig) {
                Config::get('app.integrations.custom');
                return new CacheIntegration($integrationConfig['cache-ttl'], $app->make($integrationConfig['class']));
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
