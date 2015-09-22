<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    /*
     * Log Events
     */
    const USER_LOGIN = 1;

    const LANDING_PAGE_REQUEST = 2;

    const PROBLEM_ISSUED = 4;
    const PENALIZED_PROBLEM_ISSUED = 5;

    const INCORRECT_PROBLEM_SUBMITTED = 6;
    const INCORRECT_PENALIZED_PROBLEM_SUBMITTED = 7;

    const CORRECT_PROBLEM_SUBMITTED = 8;
    const CORRECT_PENALIZED_PROBLEM_SUBMITTED = 9;

    const PENALIZED_TASK_CHOSEN_POST_REDIRECT = 10;

    const OUTGOING_QUESTIONNAIRE_COMPLETED = 11;

    const ALL_TASKS_COMPLETED = 12;

    const TASK_PENALTY_TRANSITION = 13;


    /*
     * Zero is the default task number for non task specific events.
     */
    const NO_TASK = 0;

    protected $table = 'event_logs';

    /**
     * @param \Officium\Experiment\Subject $subject
     * @param $eventType
     * @param int $taskNumber
     * @param double $payoff
     */
    public static function logEvent(Subject $subject, $eventType, $taskNumber = self::NO_TASK, $payoff = 0.0)
    {
        $eventLog = new EventLog();
        $eventLog->setSubjectId($subject->getId());
        $eventLog->setEventType($eventType);
        $eventLog->setDateTime(new \DateTime("now"));
        $eventLog->setPayoff($payoff);

        if ($taskNumber > 0) {
            $eventLog->setTaskNumber($taskNumber);
        }

        $eventLog->save();
    }

    /**
     * @param int $payoff
     */
    public function setPayoff($payoff)
    {
        $this->payoff = $payoff;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDateTime(\DateTime $datetime)
    {
        $this->date_time = $datetime;
    }

    /**
     * @param int $subjectId
     */
    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * @param int $taskNumber
     */
    public function setTaskNumber($taskNumber)
    {
        $this->task_id = $taskNumber;
    }

    /**
     * @param int $eventType
     */
    public function setEventType($eventType)
    {
        $this->event = $eventType;
    }
}