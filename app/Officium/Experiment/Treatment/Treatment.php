<?php

namespace Officium\Experiment\Treatment;

use Officium\Experiment\Treatment\Task;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'treatments';

    /**
     * @var string
     */
    public static $THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE = 'task:3_timeLimit_penalty_adjustableDeadline';

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Creates a treatment and returns its ID.
     *
     * @param $type
     * @return mixed
     */
    public static function createTreatment($type, $size)
    {
        $treatment = new Treatment();
        $treatment->type = $type;
        $treatment->size = $size;
        $treatment->save();

        return $treatment->id;
    }

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alternateDeadlineTreatment()
    {
        return $this->hasOne(get_class(new AlternateDeadlineTreatment()), 'treatment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(get_class(new Task()), 'treatment_id');
    }
}