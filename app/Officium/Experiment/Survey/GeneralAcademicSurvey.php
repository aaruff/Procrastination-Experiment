<?php

namespace Officium\Subject\Models;

use Officium\User\Models\FormModel;
use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;

class GeneralAcademicSurvey extends FormModel
{
    private $MAJOR = 'major';
    private $GPA = 'gpa';
    private $NUM_COURSES = 'number_courses';
    private $NUM_CLUBS = 'number_clubs';

    /**
     * Sets up survey
     *
     * @param array $entries
     */
    public function __construct($entries)
    {
        $keys = [$this->MAJOR, $this->GPA, $this->NUM_COURSES, $this->NUM_CLUBS];
        parent::__construct($keys, $entries);
    }

    /**
     * Validates general academic form entries.
     * @return boolean
     */
    public function validate()
    {
        // Validate input
        try {
            Validator::arr()
                ->key($this->MAJOR, Validator::notEmpty()->alpha()->length(1, 255, true))
                ->key($this->GPA, Validator::float()->between(0.0, 4.0, true))
                ->key($this->NUM_COURSES, Validator::int()->between(0, 20, true))
                ->key($this->NUM_CLUBS, Validator::int()->between(0, 20, true))
                ->assert($this->getEntries());
            return true;
        } // Handle authentication errors
        catch (ValidationException $e) {
            $this->setErrors($e->findMessages([
                $this->MAJOR => 'Invalid Entry',
                $this->GPA => 'Invalid Entry',
                $this->NUM_COURSES => 'Invalid Entry',
                $this->NUM_CLUBS => 'Invalid Entry'
            ]));
        }

        return false;
    }

}