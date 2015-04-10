<?php

namespace Officium\Framework\Validators;


/**
 * Abstract Class Validator
 * @package Officium\Framework\Validators
 */
abstract class Validator
{
    protected $error = '';

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    abstract public function validate($entry);

    /**
     * Sets the error message.
     * @param $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * Returns the error message.
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}