<?php

namespace Officium\Subject\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingSurvey extends Model
{
    public $timestamps = false;
    protected $table = 'incoming_surveys';

    public function subject()
    {
        return $this->belongsTo('Officium\Model\Subject', 'subjects');
    }
}