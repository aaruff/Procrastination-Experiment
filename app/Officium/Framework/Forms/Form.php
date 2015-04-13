<?php

namespace Officium\Framework\Forms;


/**
 * Class Form
 * @package Officium\Framework\Forms
 */
abstract class Form
{
    /**
     * @var array
     */
    private $entries = [];
    /**
     * @var array
     */
    private $errors = [];

    public function __construct($entries)
    {
       $this->entries;
    }

    /**
     * @return array
     */
    public function getFormEntries()
    {
        return $this->entries;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return array
     */
    protected function setErrors(array $errors)
    {
        return $errors;
    }
}