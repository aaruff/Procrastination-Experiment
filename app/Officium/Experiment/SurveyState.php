<?php

namespace Officium\Experiment;


abstract class SurveyState
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;

    public static function getNextState($id)
    {
        if ($id >= 0 && $id < SurveyState::EXTERNAL_OBLIGATION) {
            return $id + 1;
        }

        return 0;
    }
}