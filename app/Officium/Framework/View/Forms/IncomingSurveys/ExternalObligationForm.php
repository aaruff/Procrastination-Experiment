<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\ExternalObligationSurvey as Survey;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Validators\ArrayValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Validators\YesNoValidator;
use Officium\Framework\View\Forms\Form;
use Officium\Framework\Models\User;
use Officium\Experiment\ExternalObligationDeadline as Deadline;
use Officium\Framework\Validators\RequiredConditionalValidator;

class ExternalObligationForm extends Form implements Saveable
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
        parent::__construct(get_class($this), $entries, $this->getFormValidators());
    }

    /**
     * Stores properties to the session.
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $survey = new Survey();
        $survey->setEmployed($this->getIntEntry(self::$EMPLOYED));
        $survey->setHoursWork($this->getIntEntry(self::$HOURS_WORK));
        $survey->setHoursSocialObligations($this->getIntEntry(self::$HOURS_SOCIAL));
        $survey->setHoursFamilyObligations($this->getIntEntry(self::$HOURS_FAMILY));
        $survey->setSubjectId($user->getSubject()->getId());
        $survey->save();

        $survey->externalObligationDeadlines()->saveMany($this->getAllDeadlines());
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
        $validators[self::$EMPLOYED] = new YesNoValidator();
        $validators[self::$HOURS_WORK] = new IntegerValidator(0, 200);
        $validators[self::$HOURS_SOCIAL] = new IntegerValidator(0, 200);
        $validators[self::$HOURS_FAMILY] = new IntegerValidator(0, 200);

        $workStartValidator = new RequiredConditionalValidator([[self::$HOURS_WORK, new IntegerValidator(0, 200)]], Deadline::$WORK_START_DATE_TIME, new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false)));
        $workEndValidator = new RequiredConditionalValidator([[self::$HOURS_WORK, new IntegerValidator(0, 200)]], Deadline::$WORK_START_DATE_TIME, new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false)));
        $validators[Deadline::$WORK_START_DATE_TIME] = $workStartValidator;
        $validators[Deadline::$WORK_END_DATE_TIME] = $workEndValidator;
        $validators[Deadline::$SOCIAL_START_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[Deadline::$SOCIAL_END_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[Deadline::$FAMILY_START_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        $validators[Deadline::$FAMILY_END_DATE_TIME] = new ArrayValidator(new DateTimeValidator(self::$DATE_TIME_FORMAT, false));
        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    private function getAllDeadlines()
    {
        $entries = $this->getEntries();

        $deadlines = [
            ['start'=>Deadline::$SOCIAL_START_DATE_TIME, 'end'=>Deadline::$SOCIAL_END_DATE_TIME],
            ['start'=>Deadline::$WORK_START_DATE_TIME, 'end'=>Deadline::$WORK_END_DATE_TIME],
            ['start'=>Deadline::$FAMILY_START_DATE_TIME, 'end'=>Deadline::$FAMILY_END_DATE_TIME]];

        $dateTimes = [];
        foreach ($deadlines as $deadline) {
            $dateTimes = [];
            foreach ($entries[$deadline['start']] as $id=>$start) {
                $surveyDateTime = new Deadline();
                $surveyDateTime->setStartDateTime(\DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $start));
                $surveyDateTime->setType($start);
                $dateTimes[] = $surveyDateTime;

                if (isset($entries[$deadline['end']][$id])) {
                    $surveyDateTime->setEndDateTime(\DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $entries[$deadline['end']][$id]));
                }

            }
        }

        return $dateTimes;
    }
}