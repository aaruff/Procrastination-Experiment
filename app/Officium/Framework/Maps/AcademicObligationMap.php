<?php

namespace Officium\Framework\Maps;


use Officium\Framework\Controllers\AcademicObligationController;

class AcademicObligationMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/survey/academicObligations.twig';
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/survey/ao';
    }

    /**
     * Returns the path to the controller handling the specified request method.
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new AcademicObligationController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }
}