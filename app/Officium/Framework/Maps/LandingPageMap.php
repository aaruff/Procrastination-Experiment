<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\LandingPageController;

class LandingPageMap extends ResourceMap
{
    public static function toUri()
    {
        return '/session/landing';
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
     * @param $uri
     * @return bool
     */
    public static function isUri($uri)
    {
        return $uri === self::toUri();
    }

    /**
     * @return string
     */
    public static function toTemplate()
    {
        return '/pages/subject/landing.twig';
    }
}