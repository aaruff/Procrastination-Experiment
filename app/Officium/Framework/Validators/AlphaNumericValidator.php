<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class AlphaNumericValidator extends Validator
{
    public function validate($entry)
    {
        $this->clearErrors();
        try {
            v::notEmpty()->noWhitespace()->alnum()->assert($entry);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(
                ['noWhitespace'=>self::$WHITE_SPACE, 'notEmpty'=>self::$NOT_EMPTY, 'alnum'=>self::$ALPHA_NUM,]));
        }

        return false;
    }

}