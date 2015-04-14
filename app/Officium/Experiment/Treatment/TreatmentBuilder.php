<?php
namespace Officium\Experiment\Treatment;


use Experiment\Treatment\Task\TaskDeadline;
use Experiment\Treatment\Task\TaskPenaltyRate;
use Officium\Experiment\Treatment\Task\TaskTimeLimit;
use Officium\Framework\Forms\Form;
use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;

class TreatmentBuilder
{
    public static function buildTreatment(Form $form)
    {
        $treatmentForm = new ThreeTaskPenaltyRateForm($form->getEntries());

        $treatment = new Treatment();
        $treatment->type = $form->getType();
        $treatment->save();

        $alternateDeadlineTreatment = new AlternateDeadlineTreatment();
        $alternateDeadlineTreatment->treatment_id = $treatment->id;
        $alternateDeadlineTreatment->enabled = $treatmentForm->getAlternateTaskDeadlineOption();
        $alternateDeadlineTreatment->save();

        $taskNumber = 1;
        $deadlines = $treatmentForm->getTaskDeadlines();
        foreach ($deadlines as $deadline) {
            $task = new Task();
            $task->type = $form->getType();
            $task->number = $taskNumber++;
            $task->treatment_id = $treatment->id;
            $task->payoff = $treatmentForm->getPayoff();
            $task->save();

            $taskDeadlines = new TaskDeadline();
            $taskDeadlines->task_id = $task->id;
            $taskDeadlines->date_time = $deadline;
            $taskDeadlines->save();

            $taskTimeLimit = new TaskTimeLimit();
            $taskTimeLimit->task_id = $task->id;
            $taskTimeLimit->minutes = $treatmentForm->getTaskTimeLimits();
            $taskTimeLimit->save();

            $penaltyRate = new TaskPenaltyRate();
            $penaltyRate->task_id = $task->id;
            $penaltyRate->rate = $treatmentForm->getPenaltyRate();
            $penaltyRate->save();
        }
    }
}