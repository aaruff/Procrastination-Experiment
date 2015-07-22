<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\AttentiveRankSurvey;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\View\Forms\Form;
use Officium\Framework\Models\User;

class AttentiveRankSurveyForm extends Form implements Saveable
{
    private static $CONSCIENTIOUSNESS = 'con';
    private static $FREQUENCY_ASSIGNMENT_LATENESS = 'late';
    private static $TARDINESS = 'tar';
    private static $EXTERNAL_DISTRACTIONS = 'dist';
    private static $DEPENDABILITY = 'dep';
    private static $ABILITY_FOLLOW_SCHEDULE = 'follow';
    private static $ABILITY_TO_ORGANIZE = 'org';
    private static $ABILITY_PAY_ATTENTION = 'att';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function save(User $user)
    {
        $survey = new AttentiveRankSurvey();
        $survey->setConscientiousness($this->getIntEntry(self::$CONSCIENTIOUSNESS));
        $survey->setAssignmentLateness($this->getIntEntry(self::$FREQUENCY_ASSIGNMENT_LATENESS));
        $survey->setTardiness($this->getIntEntry(self::$TARDINESS));
        $survey->setExternalDistractions($this->getIntEntry(self::$EXTERNAL_DISTRACTIONS));
        $survey->setDependability($this->getIntEntry(self::$DEPENDABILITY));
        $survey->setAbilityFollowSchedule($this->getIntEntry(self::$ABILITY_FOLLOW_SCHEDULE));
        $survey->setAbilityOrganize($this->getIntEntry(self::$ABILITY_TO_ORGANIZE));
        $survey->setAbilityPayAttention($this->getIntEntry(self::$ABILITY_PAY_ATTENTION));
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
        $validators[self::$CONSCIENTIOUSNESS] = new IntegerValidator(1, 5);
        $validators[self::$FREQUENCY_ASSIGNMENT_LATENESS] = new IntegerValidator(1, 5);
        $validators[self::$TARDINESS] = new IntegerValidator(1, 5);
        $validators[self::$EXTERNAL_DISTRACTIONS] = new IntegerValidator(1, 5);
        $validators[self::$DEPENDABILITY] = new IntegerValidator(1, 5);
        $validators[self::$ABILITY_FOLLOW_SCHEDULE] = new IntegerValidator(1, 5);
        $validators[self::$ABILITY_TO_ORGANIZE] = new IntegerValidator(1, 5);
        $validators[self::$ABILITY_PAY_ATTENTION] = new IntegerValidator(1, 5);
        return $validators;
    }
}