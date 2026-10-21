<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bindIf('request', function ($app) {
            return $app->bound(\Illuminate\Http\Request::class)
                ? $app->make(\Illuminate\Http\Request::class)
                : \Illuminate\Http\Request::create('/');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
