<?php

namespace Officium\Models;


class Survey
{
    private $keys = [];

    /**
     * Initialize survey keys.
     *
     * @param array $keys
     */
    public function __construct(array $keys)
    {
        foreach ($keys as $key) {
            $this->keys[$key] = '';
        }
    }

    /**
     * Sets form answers.
     *
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
     *
     * @return array
     */
    public function getAnswers()
    {
        return $this->keys;
    }
}