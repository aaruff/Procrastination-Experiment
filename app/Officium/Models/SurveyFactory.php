<?php

namespace Officium\Models;


class SurveyFactory
{
    private static $surveys = [
        'a' => 'GeneralAcademicSurvey', 'ao' => 'AcademicObligationSurvey', 'eo' => 'ExternalObligationSurvey'];

    public static function make($id)
    {
        return 'Officium\\Models\\' . self::$surveys[$id];
    }
}