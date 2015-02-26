<?php

namespace Officium\Models;

use DateTime;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model as Model;


class Session extends Model
{
    public $timestamps = false;

    protected $table = 'session';
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

    /**
     * Returns error messages if the validation failed.
     *
     * @return errorMessages
     */
    public function validate($entries)
    {
        $errorMessages = [];

        // Validate input
        try {
            Validator::arr()
                ->key('size', Validator::notEmpty()->int()->between(1,100, true))
                ->key('first_task_deadline', Validator::notEmpty()->date('m-d-Y H:i:s'))
                ->key('second_task_deadline', Validator::notEmpty()->date('m-d-Y H:i:s'))
                ->key('task_three_deadline', Validator::notEmpty()->date('m-d-Y H:i:s'))
                ->key('time_limit', Validator::notEmpty()->int()->between(1,1000, true))
                ->key('payoff', Validator::notEmpty()->int()->between(1,1000, true))
                ->key('penalty', Validator::notEmpty()->numeric()->between(0,1000, true))
                ->key('subject_deadline_enabled', Validator::string()->equals('on'))
                ->assert($entries);
        }
            // Handle authentication errors
        catch (ValidationException $e) {
            $errorMessages = array_filter($e->findMessages($this->fillable));
        }

        return $errorMessages;
    }
}