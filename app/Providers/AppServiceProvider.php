<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();
        $baseUrl = "https://hirelo.serv00.net/public/storage/";
//        $baseUrl = "http://localhost:8000/storage/";
        app()->singleton('baseUrl', function () use ($baseUrl) {
            return $baseUrl;
        });

    }
}
