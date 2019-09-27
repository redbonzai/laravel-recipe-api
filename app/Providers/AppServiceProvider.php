<?php

namespace App\Providers;

use App\Services\ApiService;
use Illuminate\Support\ServiceProvider;
use App\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthService::class, static function ($app) {
            return new AuthService();
        });
        
        $this->app->singleton(ApiService::class, static function ($app) {
            return new ApiService();
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
