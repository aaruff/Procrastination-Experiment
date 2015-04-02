<?php

namespace Officium\Subject\Models;


abstract class Survey
{
    private $keys = [];
    private $entries;
    private $errors;

    /**
     * Initialize survey keys.
     * @param array $keys
     */
    public function __construct(array $keys)
    {
        foreach ($keys as $key) {
            $this->keys[$key] = '';
        }
    }

    /**
     * Validates the survey against the provided entries.
     *
     * @return mixed
     */
    abstract public function validate();

    /**
     * Sets form answers.
     * @param array $answers
     */
    public function setAnswers(array $answers)
    {
        foreach ($answers as $key=>$value) {
            $this->keys[$key] = $answers[$key];
        }
    }

    /**
     * Returns form answers.
     * @return array
     */
    public function getAnswers()
    {
        return $this->keys;
    }

    /**
     * Sets valid entries specified by the survey keys.
     * @param $raw
     */
    protected function setEntries($raw)
    {
        foreach ($this->keys as $key) {
            $this->entries[$key] = (isset($raw[$key])) ? $raw[$key] : '';
        }
    }

    /**
     * Gets entries.
     * @return mixed
     */
    protected function getEntries()
    {
        return $this->entries;
    }

    /**
     * Sets errors.
     * @param $errors
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Gets errors.
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}