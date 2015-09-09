<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class AcademicObligationSurvey extends Model
{
    protected $table = 'academic_obligation_surveys';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function academicObligationDeadlines()
    {
        return $this->hasMany(get_class(new AcademicObligationDeadline()), 'survey_id');
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
     * @param int $hours
     */
    public function setHoursCourseWork($hours)
    {
        $this->hours_course_work = $hours;
    }

    /**
     * Sets the number of exams.
     *
     * @param int $number
     */
    public function setNumberExams($number)
    {
        $this->num_exams = $number;
    }

    /**
     * @param int $number
     */
    public function setNumMajorAssignments($number)
    {
        $this->num_major_assignments = $number;
    }

    /**
     * @param int $number
     */
    public function setNumMinorAssignments($number)
    {
        $this->num_minor_assignments = $number;
    }

    /**
     * @return int
     */
    public function getNumMinorAssignments()
    {
        return $this->num_minor_assignments;
    }

    /**
     * @return int
     */
    public function getNumMajorAssignments()
    {
        return $this->num_major_assignments;
    }

    /**
     * @return int
     */
    public function getNumExams()
    {
        return $this->num_exams;
    }

    /**
     * @return int
     */
    public function getHoursCoursework()
    {
        return $this->hours_course_work;
    }

}