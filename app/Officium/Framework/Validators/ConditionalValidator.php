<?php

namespace Officium\Framework\Validators;


class ConditionalValidator extends Validator
{
    private $predicates;
    private $consequentValidator;
    private $consequentKey;

    /**
     * @param array $predicates The (keys, validator) pairs that must be true before the $validator is applied.
     * @param string $consequentKey The key used to identify the entry for validation.
     * @param Validator $consequentValidator The validator applied to the entry provided.
     */
    public function __construct(array $predicates, $consequentKey, Validator $consequentValidator)
    {
        $this->predicates = $predicates;
        $this->consequentValidator = $consequentValidator;
        $this->consequentKey = $consequentKey;
    }


    /**
     * Validates the entry provided if the predicates are true.
     *
     * @param $entries
     * @return boolean
     */
    public function validate($entries)
    {
        $this->clearErrors();
        // This validator requires array entries
        if ( ! is_array($entries)) {
            return false;
        }

        $predicateOutcome  = true;
        foreach ($this->predicates as $keyValPair) {
            $predicateKey = $keyValPair[0];
            /* @var \Officium\Framework\Validators\Validator $predicateValidator */
            $predicateValidator = $keyValPair[1];

            $entry = ($predicateValidator->getEntryType() == Validator::$SINGLE_ENTRY) ? $entries[$predicateKey] : $entries;
            if ( ! $predicateValidator->validate($entry)) {
                $predicateOutcome = false;
            }
        }

        $consequentOutcome = true;
        if ( ! $this->consequentValidator->validate($entries[$this->consequentKey])) {
            $this->setErrors($this->consequentValidator->getErrors());
            $consequentOutcome = false;
        }

        return ($predicateOutcome == true && $consequentOutcome == false) ? false : true;
    }

    public function getEntryType()
    {
        return Validator::$ALL_ENTRIES;
    }

}