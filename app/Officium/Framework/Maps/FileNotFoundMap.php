<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\FileNotFoundController;

class FileNotFoundMap extends ResourceMap
{
    /**
     * @return string
     */
    public static function toTemplate()
    {
        return '/pages/404.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/session/fileNotFound';
    }

    /**
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new FileNotFoundController());
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