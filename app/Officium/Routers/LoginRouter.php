<?php

namespace Officium\Routers;


class LoginRouter
{
    public static function getUri()
    {
        return '/login';
    }

    public static function getTemplate()
    {
        return '/pages/subject/login.twig';
    }
}