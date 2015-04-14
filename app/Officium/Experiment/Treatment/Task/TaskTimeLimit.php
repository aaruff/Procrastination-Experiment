<?php

namespace Officium\Experiment\Treatment\Task;


class TaskTimeLimit 
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