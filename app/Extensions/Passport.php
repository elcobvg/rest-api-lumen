<?php

namespace App\Extensions;

use Mockery;
use DateInterval;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\Route;

class Passport extends \MoeenBasra\LaravelPassportMongoDB\Passport
{
    /**
     * Binds the Passport routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'oauth',
            'namespace' => '\MoeenBasra\LaravelPassportMongoDB\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}
