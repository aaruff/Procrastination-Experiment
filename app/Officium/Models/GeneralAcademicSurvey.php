<?php

namespace Officium\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;

class GeneralAcademicSurvey extends Survey
{

    public function __construct($entries)
    {
        parent::__construct(['major', 'gpa', 'number_courses', 'number_clubs']);

        $this->setEntries($entries);
    }

    /**
     * Validates general academic form entries.
     * @return array
     */
    public function validate()
    {
        // Validate input
        $valid = false;
        try {
            Validator::arr()
                ->key('major', Validator::notEmpty()->alpha()->length(1, 255))
                ->key('gpa', Validator::notEmpty()->int()->between(0, 4))
                ->key('number_courses', Validator::notEmpty()->int()->between(0, 20))
                ->key('number_clubs', Validator::notEmpty()->int()->between(0, 20))
                ->assert($this->getEntries());
            $valid = true;
        } // Handle authentication errors
        catch (ValidationException $e) {
            $this->setErrors($e->findMessages([
                'major' => 'Invalid major',
                'gpa' => 'Invalid GPA',
                'number_coursers' => 'Invalid number of courses',
                'number_clubs' => 'Invalid number of clubs',
            ]));
        }

        return $valid;
    }

}