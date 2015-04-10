<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class PayoffValidator extends Validator
{
    public function validate($rate)
    {
        try {
            // TODO: Implement validation
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setError($e->getFullMessage());
        }

        return false;
    }

}