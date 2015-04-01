<?php

namespace Officium\Routers;

/**
 * Survey Route Metadata Manager
 * Class SurveyRouter
 * @package Officium\Routers
 */
class SurveyRouter
{
    private static $templates = ['a' => 'academic.twig', 'ao' => 'academicObligations.twig', 'eo' => 'externalObligations.twig'];
    private static $surveyOrder = ['a', 'ao', 'eo'];

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
        if ( isset($id) && isset(self::$templates[$id])) {
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
    public static function getNextSurveyId($id)
    {
        foreach (self::$surveyOrder as $i => $k) {
            // Found the survey ID, and there are more surveys to be completed
            if ($k == $id && $i + 1 < count(self::$surveyOrder)) {
                return self::$surveyOrder[$i + 1];
            }
        }

        return null;
    }
}