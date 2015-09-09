<?php

namespace Officium\Framework\Validators;


class SelectionValidator extends Validator
{
    private $options;
    private $required;

    public function __construct($options, $required = false)
    {
        $this->options = $options;
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

        if ( $this->required && empty($entry)) {
            $this->setErrors(['This field is required.']);
            return false;
        }

        foreach ($this->options as $option) {
            if ($entry == $option) {
                return true;
            }
        }

        $this->setErrors('Invalid selection.');
    }
}