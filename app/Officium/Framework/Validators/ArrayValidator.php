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
     * @param $entries
     * @return boolean
     */
    public function validate($entries)
    {
        if ($this->required && ( ! is_array($entries) || count($entries) == 0 )) {
            $this->setErrors('This item is required.');
            return false;
        }

        $errors = [];
        for ($i = 0; $i < count($entries); ++$i) {
            if ( ! $this->validator->validate($entries[$i])) {
                $errors[] = $this->validator->getErrors();
            }
        }

        $this->setErrors($errors);
        return empty($errors);
    }
}