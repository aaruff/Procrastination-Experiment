<?php

namespace Officium\Framework\Maps;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Controllers\SurveyController;
use Officium\Framework\Models\Session;

/**
 * Survey Resource Map
 * Class SurveyMap
 * @package Officium\Maps
 */
class SurveyMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        $templates = [
            IncomingSurveyState::GENERAL=>'academic.twig',
            IncomingSurveyState::ACADEMIC_OBLIGATION=>'academicObligations.twig',
            IncomingSurveyState::EXTERNAL_OBLIGATION=>'externalObligations.twig',
            IncomingSurveyState::ATTENTIVE_RANK=>'attentiveRank.twig',
            IncomingSurveyState::CERTIFICATE=>'certificate.twig'
        ];

        return '/pages/subject/survey/' . $templates[Session::getSurveyId()];
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