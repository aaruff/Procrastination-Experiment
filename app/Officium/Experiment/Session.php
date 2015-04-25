<?php

namespace Officium\Experiment;

use Illuminate\Database\Eloquent\Model;
use Officium\Experiment\Treatment\Treatment;

class Session extends Model
{
    public $timestamps = false;
    protected $table = 'sessions';
    protected $fillable = ['size'];

    /**
     * @param array $attributes
     * @return \Officium\Experiment\Session
     */
    public static function createFromAttributes(array $attributes)
    {
        return Session::create($attributes);
    }

    /**
     * @param $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function treatment()
    {
        return $this->hasOne(get_class(new Treatment()), 'treatment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany(get_class(new Subject()), 'treatment_id');
    }

}