<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class IncomingSurvey extends Model
{
    public $timestamps = false;
    protected $table = 'incoming_survey';

    protected $minorAssignmentDateTimes = [];

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function surveyDateTimes()
    {
        return $this->hasMany(get_class(new SurveyDateTime()), 'survey_id');
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param SurveyDateTime[] $surveyDateTimes
     */
    public function setSurveyDateTimes(array $surveyDateTimes)
    {
        foreach($surveyDateTimes as $dateTime)
        {
            $this->surveyDateTimes->add($dateTime);
        }
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
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
     * @param int $rank
     */
    public function setRankTardiness($rank)
    {
        $this->rank_tardiness = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankConscientiousness($rank)
    {
        $this->rank_conscientiousness = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankAssignmentLateness($rank)
    {
        $this->rank_assignment_lateness = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankExternalDistractions($rank)
    {
        $this->rank_external_distractions = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankDependability($rank)
    {
        $this->rank_dependability = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankAbilityFollowSchedule($rank)
    {
        $this->rank_ability_follow_schedule = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankAbilityOrganize($rank)
    {
        $this->rank_ability_organize = $rank;
    }

    /**
     * @param int $rank
     */
    public function setRankAbilityPayAttention($rank)
    {
        $this->rank_ability_pay_attention = $rank;
    }

    /**
     * @param int $certificates
     */
    public function setCertificatesYear($certificates)
    {
        $this->certificates_year = $certificates;
    }

    /**
     * @param int $temptation
     */
    public function setTemptation($temptation)
    {
        $this->temptation = $temptation;
    }

    /**
     * @param int $certificates
     */
    public function setTemptationCertificatesYear($certificates)
    {
        $this->temptation_certificates_year = $certificates;
    }

    /**
     * @param int $nights
     */
    public function setNightsPerYear($nights)
    {
        $this->nights_per_year = $nights;
    }



}