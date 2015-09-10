<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class OutgoingSurvey extends Model
{
    protected $table = 'outgoing_surveys';

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
     *                                Public Functions
     * ------------------------------------------------------------------------------------------ */
    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * @param int $comparedMinorAssignments
     */
    public function setComparedMinorAssignments($comparedMinorAssignments)
    {
        $this->compared_minor_assignments = $comparedMinorAssignments;
    }

    /**
     * @param int $hours
     */
    public function setHoursMinorAssignment($hours)
    {
        $this->hours_minor_assignments = $hours;
    }

    /**
     * @param int $comparedMajorAssignments
     */
    public function setComparedMajorAssignments($comparedMajorAssignments)
    {
        $this->compared_major_assignments = $comparedMajorAssignments;
    }

    /**
     * @param int $hours
     */
    public function setHoursMajorAssignment($hours)
    {
        $this->hours_major_assignments = $hours;
    }

    /**
     * @param int $comparedCourseWork
     */
    public function setComparedCoursework($comparedCourseWork)
    {
        $this->compared_coursework = $comparedCourseWork;
    }

    /**
     * @param int $hoursCoursework
     */
    public function setHoursCoursework($hoursCoursework)
    {
        $this->hours_coursework = $hoursCoursework;
    }

    /**
     *
     * @param int $comparedExams
     */
    public function setComparedExams($comparedExams)
    {
        $this->compared_exams = $comparedExams;
    }

    /**
     * @param int $hours
     */
    public function setHoursExams($hours)
    {
        $this->hours_exams = $hours;
    }


    /**
     * @param int $comparedWork
     */
    public function setComparedWork($comparedWork)
    {
        $this->compared_work = $comparedWork;
    }

    /**
     * @param int $hours
     */
    public function setHoursWork($hours)
    {
        $this->hours_work = $hours;
    }

    /**
     * @param int $comparedSocial
     */
    public function setComparedSocial($comparedSocial)
    {
        $this->compared_social = $comparedSocial;
    }

    /**
     * @param int $hours
     */
    public function setHoursSocial($hours)
    {
        $this->hours_social = $hours;
    }

    /**
     * @param int $comparedFamily
     */
    public function setComparedFamily($comparedFamily)
    {
        $this->compared_family = $comparedFamily;
    }

    /**
     * @param int $hours
     */
    public function setHoursFamily($hours)
    {
        $this->hours_family = $hours;
    }

    /**
     * @param int $hours
     */
    public function setHoursTasks($hours)
    {
        $this->hours_all_tasks =$hours;
    }

    /**
     * @param string $strategy
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param bool $deadlineChanged
     */
    public function setAltDeadline($deadlineChanged)
    {
        $this->deadline_changed = $deadlineChanged;
    }

    /**
     * @param bool $scheduleUsed
     */
    public function setScheduleUsed($scheduleUsed)
    {
        $this->schedule_used = $scheduleUsed;
    }

    /**
     * @param bool $scheduleUsed
     */
    public function setScheduleFollowed($scheduleUsed)
    {
        $this->schedule_used = $scheduleUsed;
    }

    /**
     * @param bool $scheduleExplained
     */
    public function setScheduleExplained($scheduleExplained)
    {
        $this->schedule_explained = $scheduleExplained;
    }

    public function setLateTaskedWorkedOn($workedOnLateTask)
    {
        $this->worked_late_task = $workedOnLateTask;
    }

    /**
     * @param bool $lateTaskExplained
     */
    public function setLateTaskExplained($lateTaskExplained)
    {
        $this->late_task_explained = $lateTaskExplained;
    }

    /**
     * @param bool $enjoyedTasks
     */
    public function setTaskEnjoyment($enjoyedTasks)
    {
        $this->enjoyed_tasks = $enjoyedTasks;
    }

    /**
     * @param int $hoursSpent
     */
    public function setHoursSpentAllTasks($hoursSpent)
    {
        $this->hours_all_tasks = $hoursSpent;
    }
}