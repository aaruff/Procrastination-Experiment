<?php

namespace Officium\Routers;

class StateRouter
{
    private static $routes = [
        0 => '/survey',
    ];

    public static function getUri($state)
    {
        return self::$routes[$state];
    }
}