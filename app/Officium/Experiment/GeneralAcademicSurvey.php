<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class GeneralAcademicSurvey extends Model
{
    protected $table = 'general_academic_surveys';

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
    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * @param string $major
     */
    public function setMajor($major)
    {
        $this->major = $major;
    }

    /**
     * @param int $gpa
     */
    public function setGPA($gpa)
    {
        $this->gpa = $gpa;
    }

    /**
     * @param int $numbers
     */
    public function setNumberCourses($numbers)
    {
        $this->number_courses = $numbers;
    }

    public function setNumberClubs($numbers)
    {
        $this->number_clubs = $numbers;
    }

}