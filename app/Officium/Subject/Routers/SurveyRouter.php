<?php

namespace Officium\Subject\Routers;

/**
 * Survey Route Metadata Manager
 * Class SurveyRouter
 * @package Officium\Routers
 */
class SurveyRouter
{
    public static $POST = 'POST';
    public static $GET = 'GET';

    private static $templates = ['a' => 'academic.twig', 'ao' => 'academicObligations.twig', 'eo' => 'externalObligations.twig'];
    private static $surveyOrder = ['a', 'ao', 'eo'];

    public static function isSurveyId($id)
    {
        if (isset(self::$templates[$id])) {
            return true;
        }

        return false;
    }

    /**
     * Returns the corresponding template route for the provided id if set, otherwise
     * the first survey template route is returned.
     *
     * @param $id
     * @return string template route
     */
    public static function getTemplateRoute($id)
    {
        $rootPath = '/pages/subject/survey/';
        if (self::isSurveyId($id)) {
            return $rootPath . self::$templates[$id];
        }

        return $rootPath . self::$templates['a'];
    }

    /**
     * Returns the next survey ID if it exists, otherwise null is returned.
     *
     * @param $id
     * @return mixed survey ID or null
     */
    public static function getNextSurveyId($id = null)
    {
        if ( self::isSurveyId($id)) {
            // Look for the next survey ID and return it
            foreach (self::$surveyOrder as $index => $surveyKey) {
                // Found the survey ID, and there are more surveys to be completed
                if ($surveyKey == $id && $index + 1 < count(self::$surveyOrder)) {
                    return self::$surveyOrder[$index + 1];
                }
            }
        }

        $firstSurvey = 1;
        return self::$surveyOrder[$firstSurvey];
    }

    public static function uri()
    {
        return '/survey';
    }

    public static function controllerRoute($method = '')
    {
        if ($method == self::$POST) {
            return '\Officium\Subject\Controllers\SurveyController:post';
        }

        return '\Officium\Subject\Controllers\SurveyController:get';
    }
}