<?php

namespace Officium\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    public static $ACADEMIC = 1;

    public static function validateSectionId($id)
    {
        $errorMessages = [];

        // Validate input
        try {
            Validator::arr()
                ->key('sid', Validator::notEmpty()->int()->equals(1))
                ->assert($id);
        } // Handle authentication errors
        catch (ValidationException $e) {
            return $errorMessages['sid'] = "Invalid section ID";
        }
    }

    public static function validate($sectionId, $credentials)
    {
        switch ($sectionId) {
            case self::ACADEMIC:
                return static::validateGeneralAcademicSurvey($credentials);
            default:
                return $errorMessages['error'] = 'Question Type Required';
        }
    }

    public static function validateGeneralAcademicSurvey($credentials)
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

    public static function questionNameToNumber($name)
    {
        $questionIdMap = [
            'major' => 1,
            'gpa' => 2,
            'course_load' => 3,
            'clubs' => 4,
        ];

        return $questionIdMap[$name];
    }

    public static function parseEntries($sectionId, $entries)
    {

    }
}