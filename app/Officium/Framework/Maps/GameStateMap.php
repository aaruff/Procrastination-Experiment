<?php

namespace Officium\Framework\Maps;

use Officium\Experiment\Subject;

class GameStateMap
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;
    const ATTENTIVE_RANK = 3;
    const CERTIFICATE = 4;
    const COMPLETED = -1;

    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Returns the uri for the given state.
     *
     * @return string
     */
    public function toUri()
    {
        if ($this->subject->getState() == self::GENERAL) {
            return SurveyMap::toUri();
        }
        else if ($this->subject->getState() == self::ACADEMIC_OBLIGATION) {
            return DeadlineMap::toUri();
        }
    }

    /**
     * @param int $state
     * @return bool
     */
    public static function isGeneralAcademicState($state)
    {
        return $state == self::GENERAL;
    }

    /**
     * @param int $state
     * @return bool
     */
    public static function isAcademicObligationState($state)
    {
        return $state == self::ACADEMIC_OBLIGATION;
    }

    /**
     * @param int $state
     * @return bool
     */
    public static function isAttentiveRankState($state)
    {
        return $state == self::ATTENTIVE_RANK;
    }

    /**
     * @param int $state
     * @return bool
     */
    public static function isExternalObligationState($state)
    {
        return $state == self::EXTERNAL_OBLIGATION;
    }

    /**
     * @param int $state
     * @return bool
     */
    public static function isCertificateState($state)
    {
        return $state == self::CERTIFICATE;
    }

    /**
     * @param int $state
     * @return bool
     */
    public static function isSurveyComplete($state)
    {
        return $state == self::COMPLETED;
    }
}