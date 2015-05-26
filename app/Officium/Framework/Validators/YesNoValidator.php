<?php

namespace Framework\Validators;

use Respect\Validation\Validator as v;
use Officium\Framework\Validators\Validator;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class YesNoValidator extends Validator
{
    private $entryRequired;
    private $mustBeYes;

    /**
     * @param bool $entryRequired Determines if the entry is required
     * @param bool $mustBeYes Determines if the  value must be true
     */
    public function __construct($entryRequired = true, $mustBeYes = false)
    {
        $this->entryRequired = $entryRequired;
        $this->mustBeYes = $mustBeYes;
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
            $val = ($this->mustBeYes) ? v::notEmpty()->yes() : v::notEmpty()->oneOf(v::yes(), v::no());
            $val->assert($entry);

            return true;
        }
        catch(NestedValidationExceptionInterface $e) {
            $messages = ['notEmpty', 'yes'];
            if ( ! $this->mustBeYes) {
                $messages[] = 'no';
            }
            $this->setErrors($e->findMessages([$messages]));
        }

        return false;
    }
}