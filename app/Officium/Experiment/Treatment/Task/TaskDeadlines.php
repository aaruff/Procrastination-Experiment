<?php

namespace Experiment\Treatment\Task;


class TaskDeadlines
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