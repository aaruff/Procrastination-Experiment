<?php

namespace Officium\Framework\Presentations\Forms;


use Officium\Framework\Validators\AlphabeticalValidator;
use Officium\Framework\Validators\IntegerValidator;

class GeneralAcademicSurveyForm extends Form
{
    private static $MAJOR = 'major';
    private static $GPA = 'gpa';
    private static $NUMBER_COURSES = 'number_courses';
    private static $NUMBER_CLUBS = 'number_clubs';

    private static $FORM_TYPE = 'general_academic';

    public function __construct($entries = [])
    {
        parent::__construct(self::$FORM_TYPE, $entries, $this->getFormValidators());
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        $validators = [];
        $validators[self::$MAJOR] = new AlphabeticalValidator();
        $validators[self::$GPA] = new IntegerValidator();
        $validators[self::$NUMBER_COURSES] = new IntegerValidator();
        $validators[self::$NUMBER_CLUBS] = new IntegerValidator();
        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function storeSurvey()
    {

    }


}