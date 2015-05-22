<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\IncomingSurvey;
use Officium\Experiment\IncomingSurveyState;
use Officium\Experiment\SurveyDateTime;
use Officium\Framework\Models\Session;
use Officium\Framework\Validators\ArrayValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\SessionStorable;
use Officium\Framework\View\Forms\Form;

class AcademicObligationForm extends Form implements SessionStorable
{
    private static $DATE_TIME_FORMAT = 'm-d-Y g:i a';

    private static $HOURS_COURSE_WORK = 'hours_course_work';

    private static $NUM_MINOR = 'num_minor';
    private static $NUM_MAJOR = 'num_major';
    private static $NUM_EXAM = 'num_exam';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function __construct($entries = [])
    {
        parent::__construct(IncomingSurveyState::ACADEMIC_OBLIGATION, $entries, $this->getFormValidators());
    }

    /**
     * Stores properties to the session.
     *
     * @return void
     */
    public function saveToSession()
    {
        $entries = [
            self::$HOURS_COURSE_WORK=>$this->getHoursCourseWork(),
            self::$NUM_MAJOR=>$this->getNumMajorAssignments(),
            self::$NUM_MINOR=>$this->getNumMinorAssignments(),
            self::$NUM_EXAM=>$this->getNumExams(),
            SurveyDateTime::$MINOR_DEADLINE_ID=>$this->getDateTimes(SurveyDateTime::$MINOR_DEADLINE_ID),
            SurveyDateTime::$MAJOR_DEADLINE_ID=>$this->getDateTimes(SurveyDateTime::$MAJOR_DEADLINE_ID),
            SurveyDateTime::$EXAM_DEADLINE_ID=>$this->getDateTimes(SurveyDateTime::$EXAM_DEADLINE_ID),
        ];

        $surveyId = Session::getSurveyId();
        Session::storeSurveyFormEntries($surveyId, $entries);
    }

    /**
     * @param IncomingSurvey $incomingSurvey
     * @return IncomingSurvey
     */
    public function setIncomingSurveyFromEntries(IncomingSurvey $incomingSurvey)
    {
        $incomingSurvey->setHoursCourseWork($this->getHoursCourseWork());
        $incomingSurvey->setNumMinorAssignments($this->getNumMinorAssignments());
        $incomingSurvey->setNumMajorAssignments($this->getNumMajorAssignments());
        $incomingSurvey->setNumberExams($this->getNumExams());
        $incomingSurvey->setSurveyDateTimes($this->getSurveyDateTime(SurveyDateTime::$MINOR_DEADLINE_ID));
        $incomingSurvey->setSurveyDateTimes($this->getSurveyDateTime(SurveyDateTime::$MAJOR_DEADLINE_ID));
        $incomingSurvey->setSurveyDateTimes($this->getSurveyDateTime(SurveyDateTime::$EXAM_DEADLINE_ID));

        return $incomingSurvey;
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
        $validators[self::$HOURS_COURSE_WORK] = new IntegerValidator(0, 200);
        $validators[self::$NUM_MINOR] = new IntegerValidator(0, 40);
        $validators[self::$NUM_MAJOR] = new IntegerValidator(0, 40);
        $validators[self::$NUM_EXAM] = new IntegerValidator(0, 40);
        $validators[SurveyDateTime::$MINOR_DEADLINE_ID] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$MAJOR_DEADLINE_ID] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$EXAM_DEADLINE_ID] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));

        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    private function getSurveyDateTime($type)
    {
        $entries = $this->getEntries();

        $dateTimes = [];
        foreach ($entries[$type] as $dateTime) {
            $surveyDateTime = new SurveyDateTime();
            $surveyDateTime->setStartDateTime(\DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $dateTime));
            $surveyDateTime->setType($type);
            $dateTimes[] = $surveyDateTime;
        }

        return $dateTimes;
    }

    /**
     * @param $type
     * @return array
     */
    private function getDateTimes($type)
    {
        $entries = $this->getEntries();

        $dateTimes = [];
        foreach ($entries[$type] as $dateTime) {
            $dateTimes[] = \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $dateTime);
        }

        return $dateTimes;
    }

    /**
     * @return int
     */
    private function getHoursCourseWork()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$HOURS_COURSE_WORK]);
    }

    /**
     * @return int
     */
    private function getNumMinorAssignments()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$NUM_MINOR]);
    }

    /**
     * @return int
     */
    private function getNumMajorAssignments()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$NUM_MAJOR]);
    }

    /**
     * @return int
     */
    private function getNumExams()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$NUM_EXAM]);
    }
}