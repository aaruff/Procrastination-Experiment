<?php
namespace Experiment\Treatment\Task;


use Illuminate\Database\Eloquent\Model;

class TaskPenaltyRate extends Model
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