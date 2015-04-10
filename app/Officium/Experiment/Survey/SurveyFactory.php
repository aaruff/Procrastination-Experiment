<?php

namespace Officium\Experiment\Survey;

use Officium\Framework\Models\FormModel;
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
     * @return FormModel
     */
    public static function make($id, $data)
    {
        $survey = new GeneralAcademicSurvey([]);
        $surveyNamespace = implode(array_slice(explode('\\', get_class($survey)), 0, -1), '\\') . '\\';
        if (isset(self::$surveys[$id])) {
            $surveyClass = $surveyNamespace . self::$surveys[$id];
            return new $surveyClass($data);
        }

        $surveyClass = get_class($survey);
        return new $surveyClass($data);
    }
}