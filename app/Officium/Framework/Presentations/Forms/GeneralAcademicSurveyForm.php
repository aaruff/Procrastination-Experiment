<?php

namespace Officium\Framework\Presentations\Forms;


use Officium\Experiment\SurveyState;
use Officium\Framework\Models\SessionStorable;
use Officium\Framework\Validators\AlphabeticalValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\Session;

class GeneralAcademicSurveyForm extends Form implements SessionStorable
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
        $validators[self::$GPA] = new FloatValidator(0, 4);
        $validators[self::$NUMBER_COURSES] = new IntegerValidator();
        $validators[self::$NUMBER_CLUBS] = new IntegerValidator();
        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function saveToSession()
    {
        $entries = [
            self::$MAJOR=>$this->getMajor(),
            self::$GPA=>$this->getGPA(),
            self::$NUMBER_COURSES=>$this->getNumberCourses(),
            self::$NUMBER_CLUBS=>$this->getNumberClubs()];

        $surveyId = Session::getSurveyState();
        Session::storeSurveyFormEntries($surveyId, $entries);

        $nextSurveyId = SurveyState::getNextSurveyId($surveyId);
        Session::setSurveyId($nextSurveyId);
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return string
     */
    private function getMajor()
    {
        $entries = $this->getEntries();
        return $entries[self::$MAJOR];
    }

    /**
     * @return float
     */
    private function getGPA()
    {
        $entries = $this->getEntries();
        return floatval($entries[self::$GPA]);
    }

    /**
     * @return int
     */
    private function getNumberCourses()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$NUMBER_COURSES]);
    }

    /**
     * @return int
     */
    private function getNumberClubs()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$NUMBER_CLUBS]);
    }
}