<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class SubjectDeadlineSurvey extends Model
{
    private static $DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    protected $table = 'subject_task_deadlines';

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
     * @param int $taskId
     */
    public function setTaskId($taskId)
    {
        $this->task_id = $taskId;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDeadline(\DateTime $dateTime)
    {
        $this->deadline = $dateTime->format(self::$DB_DATE_TIME_FORMAT);
    }

}