<?php

namespace Officium\Models;


use Illuminate\Database\Eloquent\Model;

class StateRouteMap extends Model
{
    public $timestamps = false;

    protected $table = 'state_route_maps';

    public function subjects()
    {
        return $this->belongsTo('Officium\Models\Subject', 'subjects');
    }

}