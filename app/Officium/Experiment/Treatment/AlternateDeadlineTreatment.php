<?php
namespace Officium\Experiment\Treatment;

use Illuminate\Database\Eloquent\Model;

class AlternateDeadlineTreatment extends Model
{
    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'alternate_deadline_treatments';
}