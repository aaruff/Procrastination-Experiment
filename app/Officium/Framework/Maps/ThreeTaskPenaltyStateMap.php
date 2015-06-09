<?php

namespace Officium\Framework\Maps;

use Officium\Experiment\Subject;
use Officium\Experiment\ThreeTaskPenaltyGameState;

class ThreeTaskPenaltyStateMap implements StateMap
{
    /**
     * @var \Officium\Experiment\Subject
     */
    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function toUriList()
    {
        switch($this->subject->getState()) {
            case ThreeTaskPenaltyGameState::GENERAL:
                return [GeneralAcademicMap::toUri()];
            case ThreeTaskPenaltyGameState::ACADEMIC_OBLIGATION:
                return [AcademicObligationMap::toUri()];
            case ThreeTaskPenaltyGameState::EXTERNAL_OBLIGATION:
                return [ExternalObligationMap::toUri()];
            case ThreeTaskPenaltyGameState::ATTENTIVE_RANK:
                return [AttentiveRankMap::toUri()];
            case ThreeTaskPenaltyGameState::CERTIFICATE:
                return [CertificateMap::toUri()];
            case ThreeTaskPenaltyGameState::DEADLINE:
                return [DeadlineMap::toUri()];
            case ThreeTaskPenaltyGameState::RANK_TASK_COMPLETION:
                return [RankTaskCompletionMap::toUri()];
            case ThreeTaskPenaltyGameState::TASK:
                return [LandingPageMap::toUri(), TaskMap::toUri()];
            default:
                return [LoginMap::toUri()];
        }
    }
}