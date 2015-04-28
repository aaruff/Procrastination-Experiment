<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\SurveyController;

/**
 * Survey Resource Map
 * Class SurveyMap
 * @package Officium\Maps
 */
class SurveyMap extends ResourceMap
{
    private static $templates = ['academic.twig', 'academicObligations.twig', 'externalObligations.twig'];

    /**
     * @return string template route
     */
    public static function toTemplate($surveyId)
    {
        return '/pages/subject/survey/' . self::$templates[$surveyId];
    }

    /**
     * @return string
     */
    public static function toUri()
    {
        return '/survey';
    }

    /**
     * Returns the path to the controller handling the specified request method.
     * @param string $method
     * @return string
     */
    public static function toController($method = '')
    {
        $controller = get_class(new SurveyController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }
}