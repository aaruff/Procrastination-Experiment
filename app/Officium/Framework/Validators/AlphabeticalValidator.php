<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class AlphabeticalValidator extends Validator
{
    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        $this->clearErrors();
        try {
            v::notEmpty()->noWhitespace()->alpha()->assert($entry);
            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $this->setErrors($e->findMessages(
                ['noWhitespace'=>self::$WHITE_SPACE, 'notEmpty'=>self::$NOT_EMPTY, 'alpha'=>self::$ALPHA,]));
        }

        return false;
    }
}