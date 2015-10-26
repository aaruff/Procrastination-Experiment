<?php

namespace Officium\Framework\Validators;

class ArrayValidator extends Validator
{
    private $required;
    private $validator;
    private $key;

    /**
     * @param $key
     * @param Validator $validator
     * @param bool|true $required
     */
    public function __construct($key, Validator $validator, $required = true) {
        $this->key = $key;
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
            $this->setErrors([$this->key=>'This item is required.']);
            return false;
        }

        $errors = [];
        for ($i = 0; $i < count($entry); ++$i) {
            if ( ! $this->validator->validate($entry[$i])) {
                $errors[] = implode(', ', $this->validator->getErrors());
            }
        }

        $this->setErrors([$this->key=>$errors]);
        return empty($errors);
    }
}