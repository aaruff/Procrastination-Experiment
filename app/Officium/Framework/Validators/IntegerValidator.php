<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class IntegerValidator extends Validator
{
    private $min;
    private $max;

    public function __construct($min = 0, $max = 1000)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        try {
            v::notEmpty()->int()->between($this->min, $this->max, true)->assert($entry);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setError($e->getFullMessage());
        }

        return false;
    }
}