<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class PenaltyRateValidator extends Validator
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