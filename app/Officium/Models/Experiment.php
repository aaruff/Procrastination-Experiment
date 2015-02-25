<?php

namespace Officium\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model as Model;


class Experiment extends Model
{
    public $timestamps = false;

    protected $table = 'experiment';

    /**
     * Returns error messages if the validation failed.
     *
     * @param $credentials
     * @return Validator
     */
    public static function validate($credentials)
    {
        $errorMessages = [];

        // Validate input
        try {
            Validator::arr()
                ->key('size', Validator::notEmpty()->int()->between(1,100, true))
                ->key('task_one_deadline', Validator::notEmpty()->date('m-d-Y H:i:s'))
                ->key('task_two_deadline', Validator::date('m-d-Y H:i:s'))
                ->key('task_three_deadline', Validator::date('m-d-Y H:i:s'))
                ->key('time_limit', Validator::notEmpty()->int()->between(1,1000, true))
                ->key('payoff', Validator::notEmpty()->int()->between(1,1000, true))
                ->key('penalty', Validator::notEmpty()->numeric()->between(0,1000, true))
                ->key('subject_deadline_enabled', Validator::string()->equals('on'))
                ->assert($credentials);
        }
            // Handle authentication errors
        catch (ValidationException $e) {
            $errorMessages = array_filter($e->findMessages([
                'size', 'task_one_deadline', 'task_two_deadline', 'task_three_deadline', 'time_limit',
                'payoff', 'penalty', 'subject_deadline_enabled'
            ]));
        }

        return $errorMessages;
    }
}