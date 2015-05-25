<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class IntegerValidator extends Validator
{
    private $min;
    private $max;
    private $required;

    /**
     * @param int $min Minimal integer value (inclusive)
     * @param null $max Maximum integer value (inclusive)
     * @param bool $required Entry required
     */
    public function __construct($min = 1, $max = null, $required = true)
    {
        $this->min = $min;
        $this->max = $max;
        $this->required = $required;
    }

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        $this->clearErrors();
        if ($this->min == 0 && $entry === '0') {
            return true;
        }

        // Handle cases where the entry is not required
        if ($this->required == false && empty($entry)) {
            return true;
        }

        try {
            if ($this->max == null) {
                v::notEmpty()->int()->min($this->min, true)->assert($entry);
                return true;
            }
            else {
                v::notEmpty()->int()->between($this->min, $this->max, true)->assert($entry);
                return true;
            }
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(
                [
                    'int'=>self::$INTEGER, 'notEmpty'=>self::$NOT_EMPTY,
                    'between'=>'This field must be between '.$this->min . ' and '. $this->max]));
        }

        return false;
    }
}