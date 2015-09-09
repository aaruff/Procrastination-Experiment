<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class ExternalObligationSurvey extends Model
{
    protected $table = 'external_obligation_surveys';

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
    public function externalObligationDeadlines()
    {
        return $this->hasMany(get_class(new ExternalObligationSurvey()), 'survey_id');
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * @param boolean $employed
     */
    public function setEmployed($employed)
    {
        $this->employed = $employed;
    }

    /**
     * @param int $hours
     */
    public function setHoursWork($hours)
    {
        $this->hours_work = $hours;
    }

    /**
     * @param int $hours
     */
    public function setHoursSocialObligations($hours)
    {
        $this->hours_social_obligations = $hours;
    }

    /**
     * @param int $hours
     */
    public function setHoursFamilyObligations($hours)
    {
        $this->hours_family_obligations = $hours;
    }

    /**
     * @return bool
     */
    public function getEmployed()
    {
        return $this->employed;
    }

    /**
     * @return int
     */
    public function getHoursWork()
    {
        return $this->hours_work;
    }

    /**
     * @return int
     */
    public function getHoursSocialObligations()
    {
        return $this->hours_social_obligations;
    }

    /**
     * @return int
     */
    public function getHoursFamilyObligations()
    {
        return $this->hours_family_obligations;
    }
}