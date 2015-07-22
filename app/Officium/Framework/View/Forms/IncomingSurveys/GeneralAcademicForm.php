<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\GeneralAcademicSurvey;
use Officium\Framework\Models\User;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Validators\AlphabeticalValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\View\Forms\Form;

class GeneralAcademicForm extends Form implements Saveable
{
    private static $MAJOR = 'major';
    private static $GPA = 'gpa';
    private static $NUMBER_COURSES = 'number_courses';
    private static $NUMBER_CLUBS = 'number_clubs';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * Save form entries to session storage.
     * @param User $user
     */
    public function save(User $user)
    {
        $survey = new GeneralAcademicSurvey();
        $survey->setMajor($this->getStringEntry(self::$MAJOR));
        $survey->setGPA($this->getFloatEntry(self::$GPA));
        $survey->setNumberCourses($this->getIntEntry(self::$NUMBER_COURSES));
        $survey->setNumberClubs($this->getIntEntry(self::$NUMBER_CLUBS));
        $survey->setSubjectId($user->getSubject()->getId());
        $survey->save();
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getValidators()
    {
        $validators = [];
        $validators[self::$MAJOR] = new AlphabeticalValidator(0, 200);
        $validators[self::$GPA] = new FloatValidator(0, 4);
        $validators[self::$NUMBER_COURSES] = new IntegerValidator(0, 200);
        $validators[self::$NUMBER_CLUBS] = new IntegerValidator(0, 200);
        return $validators;
    }

}