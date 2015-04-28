<?php

namespace Officium\Experiment;


abstract class SurveyState
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;
    const COMPLETED = -1;

    /**
     * Returns the next state ID.
     *
     * @param $id
     * @return int
     */
    public static function getNextSurveyId($id)
    {
        if ($id >= 0 && $id < self::EXTERNAL_OBLIGATION) {
            return $id + 1;
        }

        return self::COMPLETED;
    }

    public static function isComplete($id)
    {
        return $id == self::COMPLETED;
    }
}