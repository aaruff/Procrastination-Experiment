<?php

namespace Officium\Framework\Maps;

use Officium\Experiment\Subject;

class ThreeTaskPenaltyStateMap implements StateMap
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;
    const ATTENTIVE_RANK = 3;
    const CERTIFICATE = 4;
    const DEADLINE = 5;

    /**
     * @var \Officium\Experiment\Subject
     */
    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function toUri()
    {
        switch($this->subject->getState()) {
            case self::GENERAL:
                return GeneralAcademicMap::toUri();
            case self::ACADEMIC_OBLIGATION:
                return AcademicObligationMap::toUri();
            case self::EXTERNAL_OBLIGATION:
                return ExternalObligationMap::toUri();
            case self::ATTENTIVE_RANK:
                return AttentiveRankMap::toUri();
            case self::CERTIFICATE:
                return CertificateMap::toUri();
            case self::DEADLINE:
                return '';
            default:
                return LoginMap::toUri();
        }
    }
}