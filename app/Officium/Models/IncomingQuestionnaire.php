<?php

namespace Officium\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingQuestionnaire extends Model
{
    public $timestamps = false;
    protected $table = 'incoming_questionnaires';

    public function subject()
    {
        return $this->belongsTo('Officium\Model\Subject', 'subjects');
    }

    public static function validateGeneralAcademicQuestions($credentials)
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