<?php

namespace Officium\Framework\Forms;


/**
 * Class Form
 * @package Officium\Framework\Forms
 */
abstract class Form
{
    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @var \Officium\Framework\Validators\Validator[]
     */
    private $validators = [];

    /**
     * @param \Officium\Framework\Validators\Validator[] $validators
     */
    public function __construct($validators)
    {
        $this->validators = $validators;
    }

    /**
     * Returns the form's keys
     *
     * @return string[]
     */
    public abstract function getFormKeys();

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected abstract function getFormValidators();

    /**
     * @param string[] $entries
     * @return bool
     */
    public function validate($entries)
    {
        $errors = [];
        foreach ($this->validators as $key => $validator) {
            if ( ! $validator->validate($entries[$key])) {
                $errors[$key] = $validator->getError();
            }
        }

        $this->errors;

        return empty($errors);
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }
}