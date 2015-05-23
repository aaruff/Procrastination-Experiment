<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class AttentiveRankSurvey extends Model
{
    protected $table = 'attentive_rank_surveys';

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
     * @param int $rank
     */
    public function setTardiness($rank)
    {
        $this->tardiness = $rank;
    }

    /**
     * @param int $rank
     */
    public function setConscientiousness($rank)
    {
        $this->conscientiousness = $rank;
    }

    /**
     * @param int $rank
     */
    public function setAssignmentLateness($rank)
    {
        $this->assignment_lateness = $rank;
    }

    /**
     * @param int $rank
     */
    public function setExternalDistractions($rank)
    {
        $this->external_distractions = $rank;
    }

    /**
     * @param int $rank
     */
    public function setDependability($rank)
    {
        $this->dependability = $rank;
    }

    /**
     * @param int $rank
     */
    public function setAbilityFollowSchedule($rank)
    {
        $this->ability_follow_schedule = $rank;
    }

    /**
     * @param int $rank
     */
    public function setAbilityOrganize($rank)
    {
        $this->rank_ability_organize = $rank;
    }

    /**
     * @param int $rank
     */
    public function setAbilityPayAttention($rank)
    {
        $this->ability_pay_attention = $rank;
    }


}