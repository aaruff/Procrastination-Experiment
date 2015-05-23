<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\GeneralAcademicController;

class GeneralAcademicMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/survey/academic.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/survey/ga';
    }

    /**
     * Returns the path to the controller handling the specified request method.
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new GeneralAcademicController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }

}