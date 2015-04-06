<?php

namespace Officium\Subject\Routers;


use Officium\Framework\Routers\Router;

/**
 * Class LoginRouter
 * @package Officium\Subject\Routers
 */
class LoginRouter extends Router
{
    /**
     * Returns the login uri
     * @return string
     */
    public static function uri()
    {
        return '/login';
    }

    /**
     * Returns the route to the template
     * @return string
     */
    public static function getTemplate()
    {
        return '/pages/subject/login.twig';
    }

    /**
     * Returns the controller route.
     * @param string $method
     * @return string
     */
    public static function controllerRoute($method = '')
    {
        if ($method == self::$POST) {
            return '\Officium\Subject\Controllers\LoginController:post';
        }

        return '\Officium\Subject\Controllers\LoginController:get';
    }
}