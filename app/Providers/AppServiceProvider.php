<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\Passport;
use App\Extensions\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('Illuminate\Contracts\Pagination\LengthAwarePaginator', LengthAwarePaginator::class);
        $this->app->when(\Jenssegers\Mongodb\Eloquent\Builder::class)
            ->needs(\Illuminate\Pagination\Paginator::class)
            ->give(function () {
                return \App\Extensions\LengthAwarePaginator::class;
            });

        // Passport::ignoreMigrations();
    }
}
