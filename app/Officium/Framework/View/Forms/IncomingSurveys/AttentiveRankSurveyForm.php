<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Models\Session;
use Officium\Framework\Models\SessionStorable;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\View\Forms\Form;
use Officium\Experiment\IncomingSurvey;

class AttentiveRankSurveyForm extends Form implements SessionStorable
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
    public function __construct($entries = [])
    {
        parent::__construct(IncomingSurveyState::ATTENTIVE_RANK, $entries, $this->getFormValidators());
    }

    /**
     * Stores properties to the session.
     *
     * @return void
     */
    public function saveToSession()
    {
        $entries = [
            self::$CONSCIENTIOUSNESS=>$this->getConcientiousness(),
            self::$FREQUENCY_ASSIGNMENT_LATENESS=>$this->getFrequencyAssignmentLateness(),
            self::$TARDINESS=>$this->getTardiness(),
            self::$EXTERNAL_DISTRACTIONS=>$this->getExternalDistractions(),
            self::$DEPENDABILITY=>$this->getDependability(),
            self::$ABILITY_FOLLOW_SCHEDULE=>$this->getAbilityToFollowSchedule(),
            self::$ABILITY_TO_ORGANIZE=>$this->getAbilityToOrganize(),
            self::$ABILITY_PAY_ATTENTION=>$this->getAbilityToPayAttention()
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
        $incomingSurvey->setRankConscientiousness($this->getIntEntry(self::$CONSCIENTIOUSNESS));
        $incomingSurvey->setRankAssignmentLateness($this->getIntEntry(self::$FREQUENCY_ASSIGNMENT_LATENESS));
        $incomingSurvey->setRankTardiness($this->getIntEntry(self::$TARDINESS));
        $incomingSurvey->setRankExternalDistractions($this->getIntEntry(self::$EXTERNAL_DISTRACTIONS));
        $incomingSurvey->setRankDependability($this->getIntEntry(self::$DEPENDABILITY));
        $incomingSurvey->setRankAbilityFollowSchedule($this->getIntEntry(self::$ABILITY_FOLLOW_SCHEDULE));
        $incomingSurvey->setRankAbilityOrganize($this->getIntEntry(self::$ABILITY_TO_ORGANIZE));
        $incomingSurvey->setRankAbilityPayAttention($this->getIntEntry(self::$ABILITY_PAY_ATTENTION));

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

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    /**
     * @return int
     */
    private function getConcientiousness()
    {
        return intval($this->getEntries()[self::$CONSCIENTIOUSNESS]);
    }

    private function getFrequencyAssignmentLateness()
    {
        return intval($this->getEntries()[self::$FREQUENCY_ASSIGNMENT_LATENESS]);
    }

    private function getTardiness()
    {
        return intval($this->getEntries()[self::$TARDINESS]);
    }

    private function getExternalDistractions()
    {
        return intval($this->getEntries()[self::$EXTERNAL_DISTRACTIONS]);
    }

    private function getDependability()
    {
        return intval($this->getEntries()[self::$DEPENDABILITY]);
    }

    private function getAbilityToFollowSchedule()
    {
        return intval($this->getEntries()[self::$ABILITY_FOLLOW_SCHEDULE]);
    }

    private function getAbilityToOrganize()
    {
        return intval($this->getEntries()[self::$ABILITY_TO_ORGANIZE]);
    }

    private function getAbilityToPayAttention()
    {
        return intval($this->getEntries()[self::$ABILITY_PAY_ATTENTION]);
    }
}