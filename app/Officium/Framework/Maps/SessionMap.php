<?php

namespace Officium\Experimenter\Maps;


use Officium\User\Maps\ResourceMap;

class SessionMap extends ResourceMap
{
    /**
     * @return string
     */
    public static function toUri()
    {
        return '/experiment/session/add';
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = '\Officium\Experimenter\Controllers\Experiment\SessionController';
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
        return '/pages/experimenter/experiment/session/add.twig';
    }

}