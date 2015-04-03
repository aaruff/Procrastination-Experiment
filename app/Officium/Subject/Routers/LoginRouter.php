<?php

namespace Officium\Subject\Routers;


use Officium\Framework\Routers\Router;

class LoginRouter extends Router
{
    public static function uri()
    {
        return '/login';
    }

    public static function getTemplate()
    {
        return '/pages/subject/login.twig';
    }

    public static function controllerRoute($method = '')
    {
        if ($method == self::$POST) {
            return '\Officium\Subject\Controllers\LoginController:post';
        }

        return '\Officium\Subject\Controllers\LoginController:get';
    }
}