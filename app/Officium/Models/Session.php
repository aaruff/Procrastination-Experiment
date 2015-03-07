<?php

namespace Officium\Models;

use DateTime;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as v;
use Illuminate\Database\Eloquent\Model;


class Session extends Model
{
    public $timestamps = false;

    protected $table = 'sessions';

    protected $fillable = ['size', 'first_task_deadline', 'second_task_deadline',
        'third_task_deadline', 'time_limit', 'payoff', 'penalty', 'subject_deadline_enabled'];

    public function setFirstTaskDeadlineAttribute($dateTime)
    {
        $this->attributes['first_task_deadline'] = DateTime::createFromFormat('m-d-Y H:i:s', $dateTime);
    }

    public function setSecondTaskDeadlineAttribute($dateTime)
    {
        $this->attributes['second_task_deadline'] = DateTime::createFromFormat('m-d-Y H:i:s', $dateTime);
    }

    public function setThirdTaskDeadlineAttribute($dateTime)
    {
        $this->attributes['third_task_deadline'] = DateTime::createFromFormat('m-d-Y H:i:s', $dateTime);
    }

    public function subjects()
    {
        return $this->hasMany('Officium\Models\Subject', 'session_id');
    }

    public static function validateId($id)
    {
        try {
            v::arr()->key('id', v::int()->notEmpty()->min(0))->assert(['id' => $id]);
        }
        catch (ValidationException $e) {
            return null;
        }

        $session = Session::where('id', '=', $id)->first();

        return $session;
    }

    /**
     * Returns error messages if the validation failed.
     *
     * @return errorMessages
     */
    public static function validate($entries)
    {
        $errorMessages = [];
        // handle checkbox
        if ( ! isset($entries['subject_deadline_enabled'])) {
            $entries['subject_deadline_enabled'] = '';
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