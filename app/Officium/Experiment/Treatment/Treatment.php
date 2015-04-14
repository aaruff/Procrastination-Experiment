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
}