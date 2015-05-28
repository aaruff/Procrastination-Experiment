<?php

namespace Officium\Framework\Validators;

class ArrayValidator extends Validator
{
    private $required;
    private $validator;

    public function __construct(Validator $validator, $required = true) {
        $this->validator = $validator;
        $this->required = $required;
    }

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        $this->clearErrors();

        if ($this->required && ( ! is_array($entry) || count($entry) == 0 )) {
            $this->setErrors('This item is required.');
            return false;
        }

        $errors = [];
        for ($i = 0; $i < count($entry); ++$i) {
            if ( ! $this->validator->validate($entry[$i])) {
                $errors[] = $this->validator->getErrors();
            }
        }

        $this->setErrors($errors);
        return empty($errors);
    }
}