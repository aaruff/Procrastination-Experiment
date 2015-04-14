<?php
namespace Officium\Experiment\Treatment;


use Experiment\Treatment\Task\TaskDeadline;
use Experiment\Treatment\Task\TaskPenaltyRate;
use Officium\Experiment\Subject;
use Officium\Experiment\Treatment\Task\TaskTimeLimit;
use Officium\Framework\Forms\Form;
use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;

class TreatmentBuilder
{
    public static function buildTreatment(Form $form)
    {
        $treatmentForm = new ThreeTaskPenaltyRateForm($form->getEntries());

        $treatmentId = self::createTreatment($treatmentForm->getType());
        Subject::createSubjects($treatmentForm->getNumberSubjects(), $treatmentId);
        AlternateDeadlineTreatment::createTreatment($treatmentForm->getAlternateDeadlineOption(), $treatmentId);

        $taskNumber = 1;
        $deadlines = $treatmentForm->getTaskDeadlines();
        foreach ($deadlines as $deadline) {
            $taskId = Task::createTask($form->getType(), $taskNumber, $treatmentId, $treatmentForm->getPayoff());

            TaskDeadline::createTaskDeadline($taskId, $deadline);
            TaskTimeLimit::createTaskTimeLimit($taskId, $treatmentForm->getTaskTimeLimits());
            TaskPenaltyRate::createPenaltyRate($taskId, $treatmentForm->getPenaltyRate());
            ++$taskNumber;
        }
    }
}