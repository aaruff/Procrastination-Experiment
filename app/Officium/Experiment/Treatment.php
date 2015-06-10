<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'treatments';

    /**
     * @var string
     */
    public static $THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE = 1;

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
     * @param int $type
     */
    public function setTreatmentType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(get_class(new Task()), 'treatment_id');
    }

    /**
     * @return \Officium\Experiment\Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}