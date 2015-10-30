<?php

namespace Officium\Experiment;


use Officium\Framework\Maps\ThreeTaskPenaltyStateMap;

class StateMapFactory
{
    public static function getStateMap(Subject $subject)
    {
        /* @var \Officium\Experiment\Treatment $treatment */
        $treatment = $subject->session->treatment;

        if ($treatment->getType() == Treatment::$THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE) {
            return new ThreeTaskPenaltyStateMap($subject);
        }

        throw new \Exception('Failed to find the specified treatment type.');
    }

}