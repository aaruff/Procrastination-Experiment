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
        return '/pages/subject/survey/subjectDeadline.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/deadline';
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