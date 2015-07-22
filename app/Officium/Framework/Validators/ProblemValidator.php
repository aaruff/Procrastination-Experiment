<?php

namespace Officium\Framework\Validators;

class ProblemValidator extends Validator
{
    private $solutions;

    public function __construct(array $solutions) {
        $this->solutions = $solutions;
    }

    /**
     * Validates the entry provided.
     * @param $entries
     * @return boolean
     */
    public function validate($entries)
    {
        if ( ! is_array($entries) || empty($this->solutions)) {
            $this->setErrors(['general_error' => 'Solution not found.']);
            return false;
        }

        if (count($this->solutions) != count($entries)) {
            $this->setErrors(['general_error' => 'All entries required.']);
            return false;
        }

        $alphaValidator = new AlphabeticalValidator();
        $numSolutions = count($this->solutions);
        for ($i = 0; $i < $numSolutions; ++$i) {
            if ( ! $alphaValidator->validate($entries[$i]) || $this->solutions[$i] != $entries[$i]) {
                $this->setErrors(['general_error' => 'Invalid entry found. Please try again.']);
                return false;
            }
        }

        return true;
    }
}