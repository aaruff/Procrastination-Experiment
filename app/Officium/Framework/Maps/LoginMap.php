<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\LoginController;

/**
 * Class LoginMap
 * @package Officium\User\Maps
 */
class LoginMap extends ResourceMap
{
    /**
     * @return string
     */
    public static function toUri()
    {
        return '/login';
    }

    /**
     * @return string
     */
    public static function toTemplate()
    {
        return '/pages/user/login.twig';
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new LoginController());
        if ($method == self::$POST) {
            return $controller. ':post';
        }

        return $controller . ':get';
    }

    /**
     * Returns true if this uri is a login uri.
     *
     * @param $uri
     * @return bool
     */
    public static function isUri($uri)
    {
        return self::toUri() == $uri;
    }

}