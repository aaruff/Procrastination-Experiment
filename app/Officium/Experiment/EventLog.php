<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    const LANDING_PAGE_REQUEST = 1;
    const LANDING_PAGE_REDIRECT = 2;

    const NEW_PROBLEM_ISSUED = 3;

    const INCORRECT_SUBMISSION = 4;
    const CORRECT_SUBMISSION = 5;
    const EXPIRED_SUBMISSION = 6;

    protected $table = 'event_logs';

    /**
     * @param \Officium\Experiment\Subject $subject
     * @param $eventType
     * @param int $taskNumber
     */
    public static function logEvent(Subject $subject, $eventType, $taskNumber = 0)
    {
        $eventLog = new EventLog();
        $eventLog->setSubjectId($subject->getId());
        $eventLog->setEventType($eventType);
        $eventLog->setDateTime(new \DateTime("now"));

        if ($taskNumber > 0) {
            $eventLog->setTaskNumber($taskNumber);
        }

        $eventLog->save();
    }

    public function setDateTime(\DateTime $datetime)
    {
        $this->date_time = $datetime;
    }

    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    public function setTaskNumber($taskNumber)
    {
        $this->task_id = $taskNumber;
    }

    public function setEventType($eventType)
    {
        $this->event = $eventType;
    }
}