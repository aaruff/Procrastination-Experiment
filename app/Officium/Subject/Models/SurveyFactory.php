<?php

namespace Officium\Subject\Models;


use Officium\Routers\SurveyRouter;

/**
 * Class SurveyFactoryTest
 *
 * @package Officium\Models
 */
class SurveyFactory
{
    /**
     * @var array
     */
    private static $surveys = [
        'a' => 'GeneralAcademicSurvey', 'ao' => 'AcademicObligationSurvey', 'eo' => 'ExternalObligationSurvey'];

    /**
     * Produces the Survey for the corresponding ID. If an invalid id is provided the first survey is returned.
     *
     * @param $id
     * @param $data
     * @return Survey
     */
    public static function make($id, $data)
    {
        if (SurveyRouter::isSurveyId($id)) {
            $surveyClass = 'Officium\\Models\\' . self::$surveys[$id];
            return new $surveyClass($data);
        }

        $firstSurveyId = SurveyRouter::getNextSurveyId();
        $surveyClass = 'Officium\\Models\\' . self::$surveys[$firstSurveyId];
        return new $surveyClass($data);
    }
}