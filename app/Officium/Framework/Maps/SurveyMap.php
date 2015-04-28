<?php

namespace Officium\Framework\Maps;

use Officium\Framework\Controllers\SurveyController;
use Officium\Framework\Models\Session;

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

    public static function toController($method = '')
    {
        $controller = get_class(new SurveyController());
        if ($method == self::$POST) {
            return $controller . ':post';
        }

        return $controller . ':get';
    }
}