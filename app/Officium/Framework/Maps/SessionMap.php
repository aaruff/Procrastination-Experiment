<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\SessionController;

class SessionMap extends ResourceMap
{
    /**
     * @return string
     */
    public static function toUri()
    {
        return '/session/new';
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new SessionController());
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