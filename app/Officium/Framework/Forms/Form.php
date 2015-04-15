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
        $this->entries = $this->filterEntries($entries, array_keys($validators));
        $this->validators = $validators;
    }

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
            $this->entries = $this->filterEntries($entries, array_keys($this->validators));
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

    /**
     * Returns the form keys
     *
     * @return array
     */
    public function getFormKeys()
    {
        return array_keys($this->getFormValidators());
    }

    /**
     * Returns the form entry errors
     *
     * @return \string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Filters out valid form entries form the raw entries param
     *
     * @param $rawEntries
     * @param $keyFilters
     * @return string[]
     */
    public function filterEntries($rawEntries, $keyFilters)
    {
        $filtered = [];
        foreach ($keyFilters as $key) {
            $filtered[$key] = (isset($rawEntries[$key])) ? trim($rawEntries[$key]) : '';
        }

        return $filtered;
    }

}