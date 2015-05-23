<?php

namespace Officium\Experiment;


class StateFactory
{

    /**
     * @param Subject $subject
     * @return State
     */
    public static function makeState(Subject $subject)
    {
        /* @var \Officium\Experiment\Treatment $treatment */
        $treatment = $subject->session->treatment;

        if ($treatment->getType() == Treatment::$THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE) {
            return new ThreeTaskPenaltyGameState($subject);
        }
    }

}