<?php

namespace Officium\Framework\Presentations\Forms;


class SurveyFormFactory 
{
    /**
     * @param $surveysCompleted
     * @return SurveyFormInterface
     */
    public static function make($surveysCompleted) {
        $generalAcademic = new GeneralAcademicSurveyForm();
        if ( ! isset($surveysCompleted[$generalAcademic->getType()])) {
            return $generalAcademic;
        }
    }
}