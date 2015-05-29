<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class DateIntervalValidator extends Validator
{
    /**
     * @var string
     */
    private $dateTimeFormat = 'm-d-Y h:i a';

    private $required;

    private $entryKeys;

    /**
     * @param $entryKeys array
     * @param $format string
     * @param $required boolean
     */
    public function __construct(array $entryKeys, $format = '', $required = true)
    {
        $this->entryKeys = $entryKeys;
        $this->required = $required;

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
        if ($this->required == false && empty($datetime)) {
            return true;
        }

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