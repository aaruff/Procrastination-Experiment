<?php

namespace Officium\Experiment;


class SubjectGame
{
    /*
     * A given task can be in one of four states:
     *      FIXED_PAYOFF:       The task is active and the payoff is fixed.
     *      PENALIZED_PAYOFF:   The task is active, but the payoff is penalized by (rate)*(hours passed deadline)
     *      NO_PAYOFF:          The task has a zero payoff, and can no longer be worked on.
     *      COMPLETED:          The task problem has been completed.
     */
    const FIXED_PAYOFF = 0;
    const PENALIZED_PAYOFF = 1;
    const NO_PAYOFF = 2;
    const COMPLETED = 3;

    /**
     * @var Subject
     */
    private $subject;

    private $tasks;

    public function __construct(Subject $subject) {
        $this->subject = $subject;
        $this->tasks = $subject->getSession()->getTreatment()->getTasks();
    }

    /**
     * Returns the number of tasks.
     *
     * @return int
     */
    public function getNumTasks()
    {
        return count($this->tasks);
    }

    public function isOver()
    {
        return $this->getNumActiveTasks() == 0;
    }

    private function getNumActiveTasks()
    {
        $numTasks = $this->getNumTasks();
        $activeTaskCount = 0;
        for ($taskNumber = 1; $taskNumber <= $numTasks; ++$taskNumber) {
            $state = $this->getTaskState($taskNumber);
            if ( $state == self::PENALIZED_PAYOFF || $state == self::FIXED_PAYOFF) {
                ++$activeTaskCount;
            }
        }

        return $activeTaskCount;
    }

    public function getTaskState($taskNumber)
    {
        $subjectTask = $this->subject->getSubjectTask($taskNumber);
        if ($subjectTask->isCompleted()) {
            return self::COMPLETED;
        }

        $deadline = $this->getTaskDeadline($taskNumber);
        $task = $this->tasks[$taskNumber-1];
        $zeroDeadline = clone $deadline;
        $zeroDeadline->add(new \DateInterval("PT{$task->timeToZeroPayoff()}H"));

        $now = new \DateTime('now');

        // Before Deadline
        if ($now < $deadline) {
            return self::FIXED_PAYOFF;
        }
        // During Penalized Submission Period (Payoff must be less than 0)
        else if ($now > $deadline && $now < $zeroDeadline) {
            return self::PENALIZED_PAYOFF;
        }
        // Payoff 0
        else {
            return self::NO_PAYOFF;
        }

    }

    /**
     * Returns the task's penalty rate per hour.
     *
     * @param int $taskNumber
     * @return float
     */
    public function getPenaltyRatePerHour($taskNumber)
    {
        return $this->tasks[$taskNumber]->getPenaltyRate();
    }

    /**
     * Returns true if all other tasks with a ID less than $taskNumber is either in the PENALIZED_PAYOFF
     * or in the NO_PAYOFF state.
     *
     * @param int $taskNumber
     * @return boolean
     */
    public function isTaskAccessible($taskNumber)
    {
        // Tasks are not available when they have been completed.
        if ($this->isTaskComplete($taskNumber)) {
            return false;
        }

        $numTasks = $this->getNumTasks();
        $numFixedPayoffs = 0;
        for ($i = 1; $i <= $numTasks; ++$i) {
            if ($i == $taskNumber) {
                return $numFixedPayoffs == 0;
            }

            if ($this->getTaskState($i) == self::FIXED_PAYOFF) {
                ++$numFixedPayoffs;
            }
        }
    }

    public function getProblemDeadline($taskNumber)
    {
        $task = $this->tasks[$taskNumber-1];
        $hoursToComplete = $task->getTimeLimit();
        $now = new \DateTime('now');
        $now->add(new \DateInterval("PT{$hoursToComplete}H"));
        return $now->format('m/d/Y g:i a');
    }

    /**
     * @param $taskNumber
     * @return string
     */
    public function getTimeRemaining($taskNumber)
    {
        $taskState = $this->getTaskState($taskNumber);

        // No Payoff
        if ($taskState == self::NO_PAYOFF) {
            return 'No more time remains for this task.';
        }
        // Fixed Payoff
        elseif ($taskState == self::FIXED_PAYOFF) {
            $now = new \DateTime('now');
            $suffix = ' until the end of fixed payoff period.';
            return $now->diff($this->getTaskDeadline($taskNumber))->format('%a days, %h hours, and %i minutes') . $suffix;
        }
        // Penalized Payoff
        else {
            $task = $this->tasks[$taskNumber-1];
            $timeRemaining = $task->timeToZeroPayoff();

            $fixedDeadline = clone $this->getTaskDeadline($taskNumber);
            $fixedDeadline->add(new \DateInterval("PT{$timeRemaining}H"));

            $now = new \DateTime('now');
            $zeroDeadline = $now->diff($fixedDeadline);
            $suffix = ' until your payoff for this task is zero.';
            return $zeroDeadline->format('%a days, %h hours, and %i minutes') . $suffix;
        }

    }

    /**
     * Returns the task payoff.
     *
     * @param $taskNumber
     * @return float
     */
    public function getTaskPayoff($taskNumber)
    {
        $taskState = $this->getTaskState($taskNumber);

        if ($taskState == self::COMPLETED) {
            $subjectTask = $this->subject->getSubjectTask($taskNumber);
            return $subjectTask->getPayoff();
        }
        if ($taskState == self::NO_PAYOFF) {
            return 0.0;
        }
        elseif ($taskState == self::FIXED_PAYOFF) {
            $task = $this->tasks[$taskNumber-1];
            return $task->getPayoff();
        }
        // Penalized Payoff
        else {
            $task = $this->tasks[$taskNumber-1];
            $timeRemaining = $task->timeToZeroPayoff();

            $fixedDeadline = clone $this->getTaskDeadline($taskNumber);
            $fixedDeadline->add(new \DateInterval("PT{$timeRemaining}H"));

            $now = new \DateTime('now');
            $zeroDeadline = $now->diff($fixedDeadline);
            $penalty = $task->getPenaltyRate();
            return round($task->getPayoff() - ($timeRemaining - $zeroDeadline->h - $zeroDeadline->i/60.0)*$penalty, 2);
        }
    }

    /**
     * @param $taskNumber
     * @return bool
     */
    public function isTaskComplete($taskNumber)
    {
        $subjectTasks = $this->subject->getSubjectTasks();

        foreach ($subjectTasks as $task) {
           if ($task->getTaskNumber() == $taskNumber) {
               return $task->isCompleted();
           }
        }

        return false;
    }

    /**
     * Returns the task deadline (m/d/Y g:i a).
     *
     * @param $taskNumber
     * @return string Formatted task deadline
     */
    public function getDeadline($taskNumber)
    {
        return $this->getTaskDeadline($taskNumber)->format('m/d/Y g:i a');
    }

    /**
     * @param $taskNumber
     * @return \DateTime
     */
    private function getTaskDeadline($taskNumber)
    {
        $task = $this->tasks[$taskNumber-1];
        if ($task->isSubjectDeadlineEnabled()) {
            $subjectTasks = $this->subject->getSubjectTasks();
            return $subjectTasks[$taskNumber-1]->getDeadline();
        }
        else {
            return $task->getDeadline();
        }
    }
}