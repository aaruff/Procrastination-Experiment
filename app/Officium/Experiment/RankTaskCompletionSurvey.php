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
    public function setNumberCompleted($numberCompleted)
    {
        $this->number_completed = $numberCompleted;
    }

    /**
     * @param int $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }
}