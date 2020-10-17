<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Service\ArticleServiceInterface::class, \App\Service\Production\ArticleService::class);
        $this->app->singleton(\App\Service\TableOfContentInterface::class, \App\Service\Production\TableOfContentService::class);
        $this->app->singleton(\App\Service\TagServiceInterface::class, \App\Service\Production\TagService::class);
        $this->app->singleton(\App\Service\UserServiceInterface::class, \App\Service\Production\UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if (App::environment('production')) {
            URL::forceScheme('https');
        }
    }
}
