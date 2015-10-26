<?php

namespace Officium\Framework\Validators;


class ArraySumValidator extends Validator implements SymanticValidator
{
    private $key;
    private $sum;

    public function __construct($key, $sum)
    {
        $this->key = $key;
        $this->sum = $sum;
    }

    /**
     * Validates the entry provided. Note: Validator assumes all key entries are numeric values.
     * @param $entries
     * @return boolean
     */
    public function validate($entries)
    {
        $this->clearErrors();

        if ( ! isset($entries[$this->key]) || empty($entries[$this->key]) || ! is_array($entries[$this->key])) {
            $this->setErrors([$this->key => 'Entry required.']);
            return false;
        }

        $values = $entries[$this->key];

        $runningSum = 0;
        foreach ($values as $value) {
            $runningSum += $value;
        }

        if ($runningSum != $this->sum) {
            $this->setErrors([$this->key => 'All entries must sum to ' . $this->sum]);
            return false;
        }

        return true;
    }

    public function getEntryType()
    {
        return Validator::$ALL_ENTRIES;
    }
}