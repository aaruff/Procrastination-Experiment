<?php

namespace Experiment\Treatment\Task;


class TaskPenaltyRate
{
    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'task_penalty_rates';
}