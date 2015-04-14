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

    /**
     * @param $taskId
     * @param $rate
     */
    public static function createPenaltyRate($taskId, $rate)
    {
        $penaltyRate = new TaskPenaltyRate();
        $penaltyRate->task_id = $taskId;
        $penaltyRate->rate = $rate;
        $penaltyRate->save();
    }

}