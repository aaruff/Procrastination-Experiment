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

}