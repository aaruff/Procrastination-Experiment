<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Models\Session;
use Officium\Framework\Models\SessionStorable;
use Officium\Framework\Validators\ArrayValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Validators\SelectValidator;
use Officium\Framework\View\Forms\Form;
use Officium\Experiment\IncomingSurvey;
use Officium\Experiment\SurveyDateTime;

class ExternalObligationSurveyForm extends Form implements SessionStorable
{
    private static $DATE_TIME_FORMAT = 'm-d-Y g:i a';

    private static $EMPLOYED = 'employed';
    private static $HOURS_WORK = 'hours_work';
    private static $HOURS_SOCIAL = 'hours_social';
    private static $HOURS_FAMILY = 'hours_family';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function __construct($entries = [])
    {
        parent::__construct(IncomingSurveyState::EXTERNAL_OBLIGATION, $entries, $this->getFormValidators());
    }

    /**
     * Stores properties to the session.
     *
     * @return void
     */
    public function saveToSession()
    {
        $entries = [
            self::$EMPLOYED=>$this->getIntEntry(self::$EMPLOYED),
            self::$HOURS_WORK=>$this->getIntEntry(self::$HOURS_WORK),
            self::$HOURS_SOCIAL=>$this->getIntEntry(self::$HOURS_SOCIAL),
            self::$HOURS_FAMILY=>$this->getIntEntry(self::$HOURS_FAMILY),

            SurveyDateTime::$WORK_START_DATE_TIME=>$this->getDateTimes(SurveyDateTime::$WORK_START_DATE_TIME),
            SurveyDateTime::$WORK_END_DATE_TIME=>$this->getDateTimes(SurveyDateTime::$WORK_END_DATE_TIME),

            SurveyDateTime::$SOCIAL_START_DATE_TIME=>$this->getDateTimes(SurveyDateTime::$SOCIAL_START_DATE_TIME),
            SurveyDateTime::$SOCIAL_END_DATE_TIME=>$this->getDateTimes(SurveyDateTime::$SOCIAL_END_DATE_TIME),

            SurveyDateTime::$FAMILY_START_DATE_TIME=>$this->getDateTimes(SurveyDateTime::$FAMILY_START_DATE_TIME),
            SurveyDateTime::$FAMILY_END_DATE_TIME=>$this->getDateTimes(SurveyDateTime::$FAMILY_END_DATE_TIME),
        ];

        $surveyId = Session::getSurveyId();
        Session::storeSurveyFormEntries($surveyId, $entries);
    }


    public function setIncomingSurveyFromEntries(IncomingSurvey $incomingSurvey)
    {
        $incomingSurvey->setEmployed($this->getIntEntry(self::$EMPLOYED));
        $incomingSurvey->setHoursWork($this->getIntEntry(self::$HOURS_WORK));
        $incomingSurvey->setHoursSocialObligations($this->getIntEntry(self::$HOURS_SOCIAL));
        $incomingSurvey->setHoursFamilyObligations($this->getIntEntry(self::$HOURS_FAMILY));
        $incomingSurvey->setSurveyDateTimes($this->getSurveyDateTime(SurveyDateTime::$WORK_START_DATE_TIME, SurveyDateTime::$WORK_END_DATE_TIME));
        $incomingSurvey->setSurveyDateTimes($this->getSurveyDateTime(SurveyDateTime::$SOCIAL_START_DATE_TIME, SurveyDateTime::$SOCIAL_END_DATE_TIME));
        $incomingSurvey->setSurveyDateTimes($this->getSurveyDateTime(SurveyDateTime::$FAMILY_START_DATE_TIME, SurveyDateTime::$FAMILY_END_DATE_TIME));

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
        $validators[self::$EMPLOYED] = new SelectValidator();
        $validators[self::$HOURS_WORK] = new IntegerValidator(0, 200);
        $validators[self::$HOURS_SOCIAL] = new IntegerValidator(0, 200);
        $validators[self::$HOURS_FAMILY] = new IntegerValidator(0, 200);
        $validators[SurveyDateTime::$WORK_START_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$WORK_END_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$SOCIAL_START_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$SOCIAL_END_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$FAMILY_START_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[SurveyDateTime::$FAMILY_END_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        //TODO: Add range validation
        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    private function getSurveyDateTime($typeStart, $typeEnd)
    {
        $entries = $this->getEntries();

        $dateTimes = [];
        foreach ($entries[$typeStart] as $startDateTime) {
            $surveyDateTime = new SurveyDateTime();
            $surveyDateTime->setStartDateTime(\DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $startDateTime));
            $surveyDateTime->setType($typeStart);
            $dateTimes[] = $surveyDateTime;
        }

        /* @var \Officium\Experiment\SurveyDateTime[] $dateTimes */
        foreach ($dateTimes as $id=>$dateTime) {
            if (isset($entries[$typeEnd][$id])) {
                $dateTime->setEndDateTime(\DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $entries[$typeEnd][$id]));
            }
        }

        return $dateTimes;
    }

    private function getDateTimes($type)
    {
        $entries = $this->getEntries();

        $dateTimes = [];
        foreach ($entries[$type] as $dateTime) {
            $dateTimes[] = \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $dateTime);
        }

        return $dateTimes;
    }
}