<?php

namespace Officium\Experiment;


class ThreeTaskPenaltyGameState implements State
{
    const GENERAL = 0;
    const ACADEMIC_OBLIGATION = 1;
    const EXTERNAL_OBLIGATION = 2;
    const ATTENTIVE_RANK = 3;
    const CERTIFICATE = 4;
    const DEADLINE = 5;
    const GAME_OVER = -1;

    /**
     * @var Subject $subject
     */
    private $subject;

    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Returns the next state ID
     *
     * @param Subject
     * @return int
     */
    public function getNextState()
    {
        $stateId = $this->subject->getState();
        return ($stateId >= self::GENERAL and $stateId < self::DEADLINE) ? ++$stateId : self::GAME_OVER;
    }
}