<?php

namespace Officium\Experiment;

use Officium\Framework\Models\Session;

abstract class IncomingSurveyState
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;
    const ATTENTIVE_RANK = 3;
    const CERTIFICATE = 4;
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
    public static function isAttentiveRankState()
    {
        return Session::getSurveyId() == self::ATTENTIVE_RANK;
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
    public static function isCertificateState()
    {
        return Session::getSurveyId() == self::CERTIFICATE;
    }

    /**
     * @return bool
     */
    public static function isSurveyComplete()
    {
        return Session::getSurveyId() == self::COMPLETED;
    }

    /**
     * Updates survey state, and saves it to session storage.
     */
    public static function moveToNextSurvey()
    {
        $surveyId = Session::getSurveyId();
        if ($surveyId >= 0 && $surveyId < self::CERTIFICATE) {
            Session::setSurveyId($surveyId + 1);
        }
        else {
            Session::setSurveyId(self::COMPLETED);
        }
    }

    /**
     * Resets state
     */
    public static function reset()
    {
        Session::setSurveyId(self::GENERAL);
    }
}