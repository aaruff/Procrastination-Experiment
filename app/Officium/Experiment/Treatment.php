<?php

namespace Officium\Experiment;

use DateTime;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Model;


class Treatment extends Model
{
    public $timestamps = false;

    private static $treatmentType = 'task:3_timeLimit_penalty_adjustableDeadline';

    protected $table = 'treatments';

    protected $fillable = ['type'];

    public static function getTypes()
    {
        return self::$treatmentType;
    }

    /**
     * @param $dateTime
     */
    public function setFirstTaskDeadlineAttribute($dateTime)
    {
        $this->attributes['first_task_deadline'] = DateTime::createFromFormat('m-d-Y H:i:s', $dateTime);
    }

    /**
     * @param $dateTime
     */
    public function setSecondTaskDeadlineAttribute($dateTime)
    {
        $this->attributes['second_task_deadline'] = DateTime::createFromFormat('m-d-Y H:i:s', $dateTime);
    }

    /**
     * @param $dateTime
     */
    public function setThirdTaskDeadlineAttribute($dateTime)
    {
        $this->attributes['third_task_deadline'] = DateTime::createFromFormat('m-d-Y H:i:s', $dateTime);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany('Officium\Subject\Models\Subject', 'session_id');
    }

    /**
     * @param $id
     * @return null
     */
    public static function validateId($id)
    {
        try {
            v::arr()->key('id', v::int()->notEmpty()->min(0))->assert(['id' => $id]);
        }
        catch (ValidationException $e) {
            return null;
        }

        $session = Treatment::where('id', '=', $id)->first();

        return $session;
    }
}