<?php

namespace Officium\Routers;


class LoginRouter
{
    public static $POST = 'POST';
    public static $GET = 'GET';

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
            return '\Officium\Controllers\Subject\SubjectLoginController:post';
        }

        return '\Officium\Controllers\Subject\SubjectLoginController:get';
    }
}