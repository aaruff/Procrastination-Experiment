<?php

namespace Officium\Framework\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationExceptionInterface;

class YesNoValidator extends Validator
{
    private $required;
    private $mustBeYes;

    /**
     * @param bool $entryRequired Determines if the entry is required
     * @param bool $mustBeYes Determines if the  value must be true
     */
    public function __construct($entryRequired = true, $mustBeYes = false)
    {
        $this->required = $entryRequired;
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

        if (empty($entry)) {
            if ($this->required) {
                $this->setErrors(['This field is required.']);
                return false;
            }
            // empty allowed
            else {
                return true;
            }
        }

        if ( $this->required && empty($entry)) {
            $this->setErrors(['This field is required.']);
            return false;
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
            $this->setErrors($e->findMessages($messages));
        }

        return false;
    }
}