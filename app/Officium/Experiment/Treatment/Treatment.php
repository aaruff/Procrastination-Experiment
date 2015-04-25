<?php

namespace Officium\Experiment\Treatment;

use Illuminate\Database\Eloquent\Model;
use Officium\Experiment\Session;

class Treatment extends Model
{
    public $timestamps = false;
    protected $table = 'treatments';
    protected $fillable = ['session_id'];

    /**
     * @var string
     */
    public static $THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE = 'task:3_timeLimit_penalty_adjustableDeadline';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->session_id = $sessionId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alternateDeadlineTreatment()
    {
        return $this->hasOne(get_class(new TaskDeadline()), 'treatment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(get_class(new Task()), 'treatment_id');
    }
}