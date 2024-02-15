<?php

namespace App\Providers;

use App\Http\Controllers\Admin\UserCrudController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use URL;

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
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, //this is package controller
            UserCrudController::class //this should be your own controller
        );
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
    }
}
