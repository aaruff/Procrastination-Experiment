<?php

namespace Officium\Framework\Maps;

class StateMap extends ResourceMap
{
    private static $routes = [
        0 => '/survey',
    ];

    public static function toUri($state)
    {
        return self::$routes[$state];
    }
}