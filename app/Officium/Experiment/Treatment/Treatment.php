<?php

namespace Officium\Experiment\Treatment;


use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    /**
     * @var bool database timestamp enabled
     */
    public $timestamps = false;

    /**
     * @var string database table name
     */
    protected $table = 'treatments';

    /**
     * Creates a treatment and returns its ID.
     *
     * @param $type
     * @return mixed
     */
    public static function createTreatment($type)
    {
        $treatment = new Treatment();
        $treatment->type = $type;
        $treatment->save();

        return $treatment->id;
    }
}