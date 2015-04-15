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
     * @var string
     */
    private $dateTimeFormat = 'm-d-Y g:i a';

    /**
     * @param $format string
     */
    public function DateTimeValidator($format = '')
    {
        if ( ! empty($format)) {
            $this->dateTimeFormat = $format;
        }
    }

    /**
     * Validates the task deadlines.
     *
     * @param $datetime string
     * @return bool
     */
    public function validate($datetime)
    {
        $this->clearErrors();
        try {
            v::string()->notEmpty()->date($this->dateTimeFormat)->assert($datetime);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(
                ['date'=>self::$DATE_TIME, 'notEmpty'=>self::$NOT_EMPTY, 'string'=>self::$STRING]));
        }

        return false;
    }
}