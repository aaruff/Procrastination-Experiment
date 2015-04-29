<?php

namespace Officium\Experiment;

use Officium\Framework\Models\Session;

abstract class IncomingSurveyState
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;
    const COMPLETED = -1;

    /**
     * @return bool
     */
    public static function isGeneralAcademicState()
    {
        return Session::getSurveyId() == self::GENERAL;
    }

    /**
     * @return bool
     */
    public static function isAcademicObligationState()
    {
        return Session::getSurveyId() == self::ACADEMIC_OBLIGATION;
    }

    /**
     * @return bool
     */
    public static function isExternalObligationState()
    {
        return Session::getSurveyId() == self::EXTERNAL_OBLIGATION;
    }

    /**
     * @return bool
     */
    public static function isSurveyComplete()
    {
        return Session::getSurveyId() > self::EXTERNAL_OBLIGATION;
    }

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

    /**
     * Updates survey state, and saves it to session storage.
     */
    public static function moveToNextSurvey()
    {
        $surveyId = Session::getSurveyId();
        Session::setSurveyId($surveyId + 1);
    }
}