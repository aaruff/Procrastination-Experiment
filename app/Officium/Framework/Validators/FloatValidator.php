<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class FloatValidator extends Validator
{
    private $min;
    private $max;

    public function __construct($min = 0.0, $max = 1.0)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate($floatVal)
    {
        try {
            v::float()->notEmpty()->between($this->min, $this->max, true)->assert($floatVal);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setError($e->getFullMessage());
        }

        return false;
    }
}