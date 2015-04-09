<?php

namespace Officium\User\Maps;

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
        if ($method == self::$POST) {
            return '\Officium\User\Controllers\LoginController:post';
        }

        return '\Officium\User\Controllers\LoginController:get';
    }

}