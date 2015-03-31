<?php

namespace Officium\Routers;


class SurveyRouter
{
    private static $templates = ['a' => 'academic.twig', 'ao' => 'academicObligations.twig', 'eo' => 'externalObligations.twig'];
    private static $surveyOrder = ['a', 'ao', 'eo'];

    public static function getTemplateRoute($id)
    {
        return '/pages/subject/survey/' . self::$templates[$id];
    }

    public static function getNextSurvey($id)
    {
        return array_search($id, self::$surveyOrder);
    }

    public static function getUri($id = '')
    {
        if (empty($id)) {
            return '/survey/:id';
        }

        return '/survey/' . $id;
    }
}