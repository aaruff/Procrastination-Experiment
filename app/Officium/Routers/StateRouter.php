<?php

namespace Officium\Routers;

use Officium\Models\Subject;

class StateRouter
{
    private static $routes = [
        0 => '/survey/a',
    ];

    public static function getUri($state)
    {
        return self::$routes[$state];
    }
}