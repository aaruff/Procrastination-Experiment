<?php

namespace Officium\Experimenter\Maps;

use Officium\User\Maps\ResourceMap;

/**
 * Class DashboardRouter
 * @package Officium\Experimenter\Maps
 */
/**
 * Class DashboardMap
 * @package Officium\Experimenter\Maps
 */
class DashboardMap extends ResourceMap
{
    /**
     * @return string
     */
    public static function toUri()
    {
        return '/experiment/dashboard';
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = '\Officium\Experimenter\Controllers\Experiment\DashboardController';
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }

    /**
     * @return string
     */
    public static function toTemplate()
    {
        return '/pages/experimenter/experiment/dashboard.twig';
    }
}