<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\LandingPageController;

class LandingPageMap extends ResourceMap
{
    public static function toUri()
    {
        return '/task/home';
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new LandingPageController());
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
        return '/pages/subject/landing.twig';
    }
}