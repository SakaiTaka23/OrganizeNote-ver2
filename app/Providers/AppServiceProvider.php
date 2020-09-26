<?php

namespace App\Providers;

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
        $this->app->bind(\App\Service\ArticleServiceInterface::class, \App\Service\Production\ArticleService::class);
        $this->app->bind(\App\Service\TableOfContentInterface::class, \App\Service\Production\TableOfContentService::class);
        $this->app->bind(\App\Service\TagServiceInterface::class, \App\Service\Production\TagService::class);
        $this->app->bind(\App\Service\UserServiceInterface::class, \App\Service\Production\UserService::class);
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
