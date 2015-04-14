<?php
namespace Experiment\Treatment\Task;


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

}