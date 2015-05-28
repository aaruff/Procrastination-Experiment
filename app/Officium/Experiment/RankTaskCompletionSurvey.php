<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class RankTaskCompletionSurvey extends Model
{
    protected $table = 'task_completion_rank_surveys';

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
     * @param int $rank
     */
    public function setNoTaskRank($rank)
    {
        $this->none = $rank;
    }

    /**
     * @param int $rank
     */
    public function setOneTaskRank($rank)
    {
        $this->one_task = $rank;
    }

    /**
     * @param int $rank
     */
    public function setTwoTaskRank($rank)
    {
        $this->two_tasks = $rank;
    }

    /**
     * @param int $rank
     */
    public function setAllTaskRank($rank)
    {
        $this->all_tasks = $rank;
    }

}