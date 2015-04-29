<?php

namespace Officium\Framework\Presentations\Forms;

use Officium\Experiment\IncomingSurveyState;

class SurveyFormFactory 
{
    /**
     * @return SurveyForm
     */
    public static function make() {
        if (IncomingSurveyState::isGeneralAcademicState()) {
            return new GeneralAcademicSurveyForm();
        }
    }
}