<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\Decorators\CachedUserRepository;

class RepositoriesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Option 1. Use caching at controller level. Use CachingController as base class
        $this->app->bind('App\Repositories\Contracts\UserRepository', UserRepository::class);

        // Option 2. Use caching at repository level
        // $this->app->singleton('App\Repositories\Contracts\UserRepository', function () {
        //    return new CachedUserRepository(new UserRepository(new User));
        // });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UserRepository::class
        ];
    }
}
