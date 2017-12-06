<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Generate random string
$router->get('appKey', function () {
    return str_random('32');
});

// route for creating access_token
$router->post('accessToken', 'UserController@createAccessToken');

$router->group(['prefix' => config('app.api_prefix') . config('app.api_version')], function ($router) {

    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');

    $router->group(['middleware' => ['auth:api', 'throttle:60']], function ($router) {
        $router->post('users', 'UserController@store');
        $router->put('users/{id}', 'UserController@update');
        $router->delete('users/{id}', 'UserController@destroy');
    });
});
