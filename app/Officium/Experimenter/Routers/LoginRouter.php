<?php

namespace Officium\Experimenter\Routers;


use Officium\Framework\Routers\Router;

class LoginRouter extends Router
{
    public static function uri()
    {
        return 'experimenter/login';
    }

    public static function getTemplate()
    {
        return '/pages/experimenter/login.twig';
    }

    public static function controllerRoute($method = '')
    {
        if ($method == self::$POST) {
            return '\Officium\Experimenter\Controllers\LoginController:post';
        }

        return '\Officium\Subject\Experimenter\LoginController:get';
    }

}