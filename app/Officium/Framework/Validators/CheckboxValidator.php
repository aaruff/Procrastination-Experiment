<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;

class CheckboxValidator extends Validator
{
    public function validate($item)
    {
        // TODO: Implement with exceptions
        return v::when(v::notEmpty(), v::true())->validate($item);
    }
}