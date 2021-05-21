<?php

namespace App\Providers;

use App\Integrations\Custom\CustomIntegration;
use App\Integrations\Github\GithubIntegration;
use App\Integrations\Gitlab\GitlabIntegration;
use App\Integrations\Integration;
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
        $this->app->when(Integration::class);
        $this->app->singleton('integration.custom', CustomIntegration::class);
        $this->app->singleton('integration.github', GithubIntegration::class);
        $this->app->singleton('integration.gitlab', GitlabIntegration::class);
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
