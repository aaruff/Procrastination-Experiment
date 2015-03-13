<?php

namespace Officium\Models;

use Respect\Validation\Exceptions\ValidationExceptionInterface as ValidationException;
use Respect\Validation\Validator as Validator;
use Illuminate\Database\Eloquent\Model;

class GeneralAcademicSurvey extends Model
{
    public $timestamps = false;
    protected $table = 'general_academic_survey_answers';

    public function subject()
    {
        return $this->belongsTo('Officium\Model\Subject', 'subjects');
    }

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

    public function setAnswers(Subject $subject, array $answers)
    {
        $this->subject_id = $subject->id;
        $this->major = $answers['major'];
        $this->gpa = $answers['gpa'];
        $this->number_courses = $answers['number_courses'];
        $this->number_clubs = $answers['number_clubs'];
    }
}