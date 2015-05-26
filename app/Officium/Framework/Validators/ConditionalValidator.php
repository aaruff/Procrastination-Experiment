<?php

namespace Officium\Framework\Validators;


class ConditionalValidator extends Validator
{
    private $predicates;
    private $validator;
    private $key;

    /**
     * @param array $predicates The (keys, validator) pairs that must be true before the $validator is applied.
     * @param string $key The key used to identify the entry for validation.
     * @param Validator $validator The validator applied to the entry provided.
     */
    public function __construct(array $predicates, $key, Validator $validator)
    {
        $this->predicates = $predicates;
        $this->validator = $validator;
        $this->key = $key;
    }


    /**
     * Validates the entry provided if the predicates are true.
     *
     * @param $entry
     * @return boolean
     */
    public function validate($entry)
    {
        if ( ! is_array($entry)) {
            return false;
        }

        $validationPassed  = true;
        foreach ($this->predicates as $keyValPair) {
            $key = $keyValPair[0];
            /* @var \Officium\Framework\Validators\Validator $validator */
            $validator = $keyValPair[1];

            $entry = ($validator->getEntryType() == Validator::$SINGLE_ENTRY) ? $entry[$key] : $entry;
            if ( ! $validator->validate($entry)) {
                $validationPassed = false;
            }
        }

        if ( ! $validationPassed) {
            return false;
        }

        $entry = ($this->validator->getEntryType() == Validator::$SINGLE_ENTRY) ? $entry[$this->key] : $entry;
        if ( ! $this->validator->validate($entry)) {
            $this->setErrors($this->validator->getErrors());
            return false;
        }

        return true;
    }

    public function getEntryType()
    {
        return self::$ALL_ENTRIES;
    }

}