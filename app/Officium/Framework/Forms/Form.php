<?php

namespace Officium\Framework\Forms;


/**
 * Class Form
 * @package Officium\Framework\Forms
 */
abstract class Form
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @var string[]
     */
    private $entries = [];

    /**
     * @var \Officium\Framework\Validators\Validator[]
     */
    private $validators = [];

    /**
     * @param string
     * @param string[]
     * @param \Officium\Framework\Validators\Validator[] $validators
     */
    public function __construct($type, $entries, $validators)
    {
        $this->type = $type;
        $this->entries = $entries;
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
    public function validate($entries = [])
    {
        if ( ! empty($entries) ) {
            $this->entries = $entries;
        }

        $errors = [];
        foreach ($this->validators as $key => $validator) {
            if ( ! $validator->validate($this->entries[$key])) {
                $errors[$key] = $validator->getError();
            }
        }

        $this->errors;

        return empty($errors);
    }

    /**
     * @return \string[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}