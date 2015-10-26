<?php

namespace Officium\Framework\Validators;


/**
 * Abstract Class Validator
 * @package Officium\Framework\Validators
 */
abstract class Validator
{
    protected static $NOT_EMPTY = 'This field is required.';
    protected static $TRUE = 'This field must be true.';
    protected static $FALSE = 'This field must be false';
    protected static $DATE_TIME = 'This field requires a validly formatted Date and Time.';
    protected static $STRING = 'This field must consist of only text.';
    protected static $FLOAT = 'This field must be a floating point number.';
    protected static $INTEGER = 'This field must be an integer.';
    protected static $WHITE_SPACE = 'This field must not contain whitespace.';
    protected static $ALPHA = 'This field must contain only letters.';
    protected static $ALPHA_NUM = 'This field must contain only letters and numbers.';

    /**
     * @var string[]
     */
    protected $errors = [];

    public static $SINGLE_ENTRY = 1;
    Public static $ALL_ENTRIES = 2;

    /* ------------------------------------------------------------------------------------------
     *                                      Abstract
     * ------------------------------------------------------------------------------------------ */

    /**
     * Validates the entry provided.
     * @param $entry
     * @return boolean
     */
    abstract public function validate($entry);


    /* ------------------------------------------------------------------------------------------
     *                                       Public
     * ------------------------------------------------------------------------------------------ */
    /**
     * Returns the entry type.
     *
     * @return int Entry type
     */
    public function getEntryType() {
        return self::$SINGLE_ENTRY;
    }


    /**
     * Sets the error message.
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Returns the error message.
     * @return array
     */
    public function getErrors()
    {
        $parsedErrors = [];
        foreach ($this->errors as $error) {
            if ( ! empty($error)) {
                $parsedErrors[] = $error;
            }
        }

        return $parsedErrors;
    }

    /**
     * Clears any errors that might be stored from a previous validation.
     */
    public function clearErrors()
    {
        $this->errors = [];
    }
}