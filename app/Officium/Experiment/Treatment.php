<?php

namespace Officium\Experimenter\Models;

use DateTime;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Model;


class Treatment extends Model
{
    public $timestamps = false;

    private static $treatmentTypes = ['task:1', 'task:3', 'task:3_timeLimit_penalty_adjustableDeadline'];

    protected $table = 'treatments';

    protected $fillable = ['type'];

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

    /**
     * Returns error messages if the validation failed.
     *
     * @param $entries
     * @return string errorMessages
     */
    public static function validate($entries)
    {
        $errorMessages = [];
        if (isset($entries['type']) && v::string()->notEmpty()->validate($entries['type']) && ! in_array($entries['type'], self::$treatmentTypes)) {
           $errorMessages['general'] = 'Invalid form submission.';
        }

        // Validate input
        try {
            v::arr()
                ->key('subject_deadline_enabled', v::yes())
                ->key('size', v::notEmpty()->int()->between(1,100, true))
                ->key('first_task_deadline', v::notEmpty()->date('m-d-Y H:i:s'))
                ->key('second_task_deadline', v::notEmpty()->date('m-d-Y H:i:s'))
                ->key('task_three_deadline', v::notEmpty()->date('m-d-Y H:i:s'))
                ->key('time_limit', v::notEmpty()->int()->between(1,1000, true))
                ->key('payoff', v::notEmpty()->int()->between(1,1000, true))
                ->key('penalty', v::notEmpty()->numeric()->between(0,1000, true))
                ->assert($entries);
        }
            // Handle authentication errors
        catch (ValidationException $e) {
            $errorMessages = array_filter($e->findMessages(
                ['size', 'first_task_deadline', 'second_task_deadline', 'third_task_deadline',
                    'time_limit', 'payoff', 'penalty', 'subject_deadline_enabled']));
        }

        return $errorMessages;
    }
}