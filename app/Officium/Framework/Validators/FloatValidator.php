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
        $this->clearErrors();
        try {
            v::float()->notEmpty()->between($this->min, $this->max, true)->assert($floatVal);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(['float'=>self::$FLOAT, 'notEmpty'=>self::$NOT_EMPTY,
                'between'=>'This field must be between '.$this->min . ' and '. $this->max]));
        }

        return false;
    }
}