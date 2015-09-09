<?php

namespace Officium\Framework\Maps;

use Officium\Experiment\Subject;
use Officium\Experiment\ThreeTaskPenaltyGameState;
use Slim\Slim;
use Officium\Experiment\SubjectGame;

class ThreeTaskPenaltyStateMap implements StateMap
{
    /**
     * @var \Officium\Experiment\Subject
     */
    private $subject;
    private $tasks;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function isStateValidUri($uri)
    {
        switch($this->subject->getState()) {
            case ThreeTaskPenaltyGameState::GENERAL:
                return GeneralAcademicMap::isUri($uri);
            case ThreeTaskPenaltyGameState::ACADEMIC_OBLIGATION:
                return AcademicObligationMap::isUri($uri);
            case ThreeTaskPenaltyGameState::EXTERNAL_OBLIGATION:
                return ExternalObligationMap::isUri($uri);
            case ThreeTaskPenaltyGameState::ATTENTIVE_RANK:
                return AttentiveRankMap::isUri($uri);
            case ThreeTaskPenaltyGameState::CERTIFICATE:
                return CertificateMap::isUri($uri);
            case ThreeTaskPenaltyGameState::DEADLINE:
                return DeadlineMap::isUri($uri);
            case ThreeTaskPenaltyGameState::RANK_TASK_COMPLETION:
                return RankTaskCompletionMap::isUri($uri);
            case ThreeTaskPenaltyGameState::TASK:
                if (LandingPageMap::isUri($uri)) {
                     return true;
                }
                elseif(TaskMap::isUri($uri)) {
                    $taskNumber = TaskMap::getTaskNumber($uri);
                    $game = new SubjectGame($this->subject);

                    if ($game->isOver()) {
                        $this->subject->setNextState();
                        $this->subject->save();
                        return false;
                    }

                    return $game->isTaskAccessible($taskNumber);
                 }
                else {
                    return false;
                }
            case ThreeTaskPenaltyGameState::OUTGOING_SURVEY:
                return OutgoingQuestionnaireMap::isUri($uri);
            default:
                return false;
        }
    }

    /**
     * @return string
     */
    public function getStateUri()
    {
        switch($this->subject->getState()) {
            case ThreeTaskPenaltyGameState::GENERAL:
                return GeneralAcademicMap::toUri();
            case ThreeTaskPenaltyGameState::ACADEMIC_OBLIGATION:
                return AcademicObligationMap::toUri();
            case ThreeTaskPenaltyGameState::EXTERNAL_OBLIGATION:
                return ExternalObligationMap::toUri();
            case ThreeTaskPenaltyGameState::ATTENTIVE_RANK:
                return AttentiveRankMap::toUri();
            case ThreeTaskPenaltyGameState::CERTIFICATE:
                return CertificateMap::toUri();
            case ThreeTaskPenaltyGameState::DEADLINE:
                return DeadlineMap::toUri();
            case ThreeTaskPenaltyGameState::RANK_TASK_COMPLETION:
                return RankTaskCompletionMap::toUri();
            case ThreeTaskPenaltyGameState::TASK:
                return LandingPageMap::toUri();
            case ThreeTaskPenaltyGameState::OUTGOING_SURVEY:
                return OutgoingQuestionnaireMap::toUri();
            default:
                return LoginMap::toUri();
        }
    }
}