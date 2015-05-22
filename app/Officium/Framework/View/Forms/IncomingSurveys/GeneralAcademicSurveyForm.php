<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\IncomingSurvey;
use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Models\SessionStorable;
use Officium\Framework\Validators\AlphabeticalValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\Form;

class GeneralAcademicSurveyForm extends Form implements SessionStorable
{
    private static $MAJOR = 'major';
    private static $GPA = 'gpa';
    private static $NUMBER_COURSES = 'number_courses';
    private static $NUMBER_CLUBS = 'number_clubs';

    public function __construct($entries = [])
    {
        parent::__construct(IncomingSurveyState::GENERAL, $entries, $this->getFormValidators());
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
        $validators[self::$MAJOR] = new AlphabeticalValidator(0, 200);
        $validators[self::$GPA] = new FloatValidator(0, 4);
        $validators[self::$NUMBER_COURSES] = new IntegerValidator(0, 200);
        $validators[self::$NUMBER_CLUBS] = new IntegerValidator(0, 200);
        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * Save form entries to session storage.
     */
    public function saveToSession()
    {
        $entries = [
            self::$MAJOR=>$this->getMajor(),
            self::$GPA=>$this->getGPA(),
            self::$NUMBER_COURSES=>$this->getNumberCourses(),
            self::$NUMBER_CLUBS=>$this->getNumberClubs()];

        $surveyId = Session::getSurveyId();
        Session::storeSurveyFormEntries($surveyId, $entries);
    }

    /**
     * Retrieve form entries from session storage.
     */
    public function setFromSession()
    {
        $this->setEntries(Session::getSurveyFormEntries(IncomingSurveyState::GENERAL));
    }

    /**
     * Sets and returns the IncomingSurvey with this forms entries.
     *
     * @param IncomingSurvey $survey
     * @return IncomingSurvey
     */
    public function setIncomingSurveyFromEntries(IncomingSurvey $survey)
    {
        $survey->setMajor($this->getMajor());
        $survey->setGPA($this->getGPA());
        $survey->setNumberCourses($this->getNumberCourses());
        $survey->setNumberClubs($this->getNumberClubs());

        return $survey;
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