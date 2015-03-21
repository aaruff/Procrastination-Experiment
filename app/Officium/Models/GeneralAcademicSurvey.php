<?php

namespace Officium\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;

class GeneralAcademicSurvey
{
    private $keys = ['major'=>'', 'gpa'=>'', 'number_courses'=>'', 'number_clubs'=>''];


    public static function validate($credentials)
    {
        $errorMessages = [];

        // Validate input
        try {
            Validator::arr()
                ->key('major', Validator::notEmpty()->alpha()->length(1, 255))
                ->key('gpa', Validator::notEmpty()->int()->between(0, 4))
                ->key('number_courses', Validator::notEmpty()->int()->between(0, 20))
                ->key('number_clubs', Validator::notEmpty()->int()->between(0, 20))
                ->assert($credentials);
        } // Handle authentication errors
        catch (ValidationException $e) {
            $errorMessages = $e->findMessages([
                'major' => 'Invalid major',
                'gpa' => 'Invalid GPA',
                'number_coursers' => 'Invalid number of courses',
                'number_clubs' => 'Invalid number of clubs',
            ]);
        }

        return $errorMessages;
    }

    public function setAnswers(array $answers)
    {
        foreach ($answers as $key=>$value) {
            $this->keys[$key] = $answers[$key];
        }
    }
}