<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class BooleanValidator extends Validator
{
    private $entryRequired;
    private $mustBeTrue;

    /**
     * @param bool $entryRequired Determines if the entry is required
     * @param bool $mustBeTrue Determines if the  value must be true
     */
    public function __construct($entryRequired = true, $mustBeTrue = false)
    {
        $this->entryRequired = $entryRequired;
        $this->mustBeTrue = $mustBeTrue;
    }

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        $this->clearErrors();
        if ( ! $this->entryRequired && empty($entry)) {
            return true;
        }

        try {
            $val = ($this->mustBeTrue) ? v::notEmpty()->true() : v::notEmpty()->oneOf(v::true(), v::false());
            $val->assert($entry);

            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $messages = ['notEmpty', 'true'];
            if ( ! $this->mustBeTrue) {
                $messages[] = 'false';
            }

            $this->setErrors($e->findMessages($messages));
        }

        return false;
    }
}