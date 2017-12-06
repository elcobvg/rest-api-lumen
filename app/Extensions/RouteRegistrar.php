<?php

namespace App\Extensions;

use Laravel\Lumen\Routing\Router;

class RouteRegistrar extends \MoeenBasra\LaravelPassportMongoDB\RouteRegistrar
{
    /**
     * Create a new route registrar instance.
     *
     * @param  \Laravel\Lumen\Routing\Router  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
}
