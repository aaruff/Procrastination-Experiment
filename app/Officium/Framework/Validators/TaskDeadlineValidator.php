<?php

namespace Officium\Framework\Validators;


use Officium\Experiment\Subject;

class TaskDeadlineValidator extends Validator
{
    protected static $DATE_TIME_FORMAT = 'm-d-Y h:i a';

    /**
     * @var \Officium\Framework\Models\Subject
     */
    private $subject;

    private $key;
    private $taskId;

    public function __construct(Subject $subject, $key, $taskId)
    {
        $this->subject = $subject;
        $this->key = $key;
        $this->taskId = $taskId;
    }

    /**
     * Validates the entry provided.
     * @param $entries
     *
     * @return boolean
     */
    public function validate($entries)
    {
        $this->clearErrors();

        $tasks = $this->subject->getSession()->getTreatment()->getTasks();
        $task = $tasks[$this->taskId - 1];

        $subjectDeadline = \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $entries[$this->key]);

        $hourFromNow = new \DateTime("now");
        $hourFromNow->add(new \DateInterval('PT30M'));
        if ($task->getDeadline() < $subjectDeadline) {
            $this->setErrors([$this->key => 'Your deadline on or before ' . $task->getDeadline()->format('m/d/Y g:i a') . '.' ]);
            return false;
        }
        elseif ($subjectDeadline < $hourFromNow) {
            $this->setErrors([$this->key => 'Your deadline must be after ' . $hourFromNow->format('m/d/Y g:i a') . '.' ]);
            return false;
        }


        return true;
    }


    public function getEntryType()
    {
        return Validator::$ALL_ENTRIES;
    }
}

