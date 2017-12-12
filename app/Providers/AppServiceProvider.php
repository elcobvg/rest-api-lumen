<?php

namespace App\Providers;

use App\Extensions\Passport;
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
        // Passport::ignoreMigrations();
    }
}
