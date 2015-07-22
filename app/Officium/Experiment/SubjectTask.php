<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class SubjectTask extends Model
{
    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    protected $table = 'subject_tasks';

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(get_class(new Subject()), 'subject_id');
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */
    /**
     * @param int $subjectId
     */
    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * @param \DateTime $timeCompleted
     */
    public function setTimeCompleted(\DateTime $timeCompleted)
    {
        $this->completed_datetime = $timeCompleted->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * @param int $taskNumber
     */
    public function setTaskNumber($taskNumber)
    {
        $this->task_id = $taskNumber;
    }

    /**
     * @param float $payoff
     */
    public function setPayoff($payoff)
    {
        $this->payoff = $payoff;
    }

    /**
     * @return float
     */
    public function getPayoff()
    {
        return $this->payoff;
    }

    /**
     * Returns the task number.
     * @return int
     */
    public function getTaskNumber()
    {
        return $this->task_id;
    }

    /**
     * @return \DateTime
     */
    public function getTimeCompleted()
    {
        return $this->completed_datetime;
    }

    /**
     * Sets the task fixed payoff deadline.
     * @param \DateTime $deadline
     */
    public function setDeadline(\DateTime $deadline)
    {
        $this->deadline = $deadline->format(self::$DB_DATE_TIME_FORMAT);
    }

    /**
     * Returns true if the task has been completed, otherwise false is returned.
     *
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * Sets the tasks completion state.
     * @param bool $state
     */
    public function setCompleted($state)
    {
        $this->completed = $state;
    }

    /**
     * Returns the deadline for this task
     * @return \DateTime
     */
    public function getDeadline()
    {
        return \DateTime::createFromFormat(self::$DB_DATE_TIME_FORMAT, $this->deadline);
    }
}