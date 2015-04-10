<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

/**
 * Class TaskDeadlineValidator
 * @package Officium\Framework\Validators
 */
class DateTimeValidator extends Validator
{
    /**
     * Validates the task deadlines.
     *
     * @param $deadlines
     * @return bool
     */
    public function validate($deadlines)
    {
        try {
            v::arr()->notEmpty()->each(v::date('m-d-Y g:i a'))->assert($deadlines);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
           $this->setError($e->getFullMessage());
        }

        return false;
    }
}