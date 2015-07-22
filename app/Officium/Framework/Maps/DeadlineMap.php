<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\DeadlineController;

class DeadlineMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/survey/subjectDeadlines.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/dl';
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
        $controller = get_class(new DeadlineController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }

}