<?php

namespace Officium\Framework\Maps;


class SurveyCompleteMap extends ResourceMap
{
    /**
     * @return string template route
     */
    public static function toTemplate()
    {
        return '/pages/subject/survey/complete.twig';
    }

}