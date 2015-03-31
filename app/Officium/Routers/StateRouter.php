<?php

namespace Officium\Routers;


class StateRouter
{
    private static $routes = [
        0 => '/survey/a',
    ];

    public static function getRoute(Subject $subject)
    {
        return self::$routes[$subject];
    }
}