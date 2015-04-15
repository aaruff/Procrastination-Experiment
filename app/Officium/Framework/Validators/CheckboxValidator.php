<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class CheckboxValidator extends Validator
{
    private $required;

    public function __construct($required = false)
    {
        $this->required = $required;
    }

    public function validate($item)
    {
        $this->clearErrors();
        try {
            if ( ! $this->required) {
                v::when(v::notEmpty(), v::true())->assert($item);
            }
            else {
                v::notEmpty()->true()->assert($item);
            }
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(['notEmpty'=>self::$NOT_EMPTY, 'true'=>self::$TRUE]));
        }

        return false;
    }
}