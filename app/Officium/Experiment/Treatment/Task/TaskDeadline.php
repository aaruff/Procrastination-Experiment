<?php
namespace Officium\Experiment\Treatment\Task;


use Illuminate\Database\Eloquent\Model;

class TaskDeadline extends Model
{
    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'task_deadlines';

    /**
     * @param $taskId
     * @param $deadline
     */
    public static function createTaskDeadline($taskId, $deadline)
    {
        $taskDeadlines = new TaskDeadline();
        $taskDeadlines->task_id = $taskId;
        $taskDeadlines->date_time = $deadline;
        $taskDeadlines->save();
    }

}