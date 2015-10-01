<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\AttentiveRankController;

class AttentiveRankMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/survey/attentiveRank.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/session/survey/att';
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
     * Returns the path to the controller handling the specified request method.
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new AttentiveRankController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }

}