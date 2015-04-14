<?php

namespace Officium\Experiment\Treatment\Task;


use Illuminate\Database\Eloquent\Model;

class TaskTimeLimit extends Model
{
    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'task_time_limits';

    /**
     * @param $taskId
     * @param $minutes
     */
    public static function createTaskTimeLimit($taskId, $minutes)
    {
        $taskTimeLimit = new TaskTimeLimit();
        $taskTimeLimit->task_id = $taskId;
        $taskTimeLimit->minutes = $minutes;
        $taskTimeLimit->save();
    }

}