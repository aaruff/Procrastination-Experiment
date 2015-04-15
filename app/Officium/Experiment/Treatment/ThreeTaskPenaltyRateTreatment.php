<?php

namespace Officium\Experiment\Treatment;

use Officium\Experiment\Treatment\Task\TaskDeadline;
use Officium\Experiment\Treatment\Task\TaskPenaltyRate;
use Officium\Experiment\Subject;
use Officium\Experiment\Treatment\Task\TaskTimeLimit;
use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;

class ThreeTaskPenaltyRateTreatment 
{
    public static function create(ThreeTaskPenaltyRateForm $treatmentForm)
    {
        $treatmentId = Treatment::createTreatment($treatmentForm->getType());
        Subject::createSubjects($treatmentForm->getNumberSubjects(), $treatmentId);
        AlternateDeadlineTreatment::createTreatment($treatmentForm->getAlternateDeadlineOption(), $treatmentId);

        $taskNumber = 1;
        $deadlines = $treatmentForm->getTaskDeadlines();
        foreach ($deadlines as $deadline) {
            $taskId = Task::createTask($taskNumber, $treatmentId, $treatmentForm->getPayoff());
            TaskDeadline::createTaskDeadline($taskId, $deadline);
            TaskTimeLimit::createTaskTimeLimit($taskId, $treatmentForm->getTaskTimeLimits());
            TaskPenaltyRate::createPenaltyRate($taskId, $treatmentForm->getPenaltyRate());
            ++$taskNumber;
        }
    }
}