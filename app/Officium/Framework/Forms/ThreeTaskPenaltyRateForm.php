<?php

namespace Officium\Framework\Forms;

use Officium\Framework\Validators\CheckboxValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\DateTimeValidator;

class ThreeTaskPenaltyRateForm extends Form
{
    private static $formType = 'task:3_timeLimit_penalty_adjustableDeadline';

    public static $NUMBER_SUBJECTS_KEY = 'size';
    public static $ALTERNATE_TASK_DEADLINE_KEY = 'adjustableDeadline';
    public static $PENALTY_RATE_KEY = 'penaltyRate';
    public static $TASK_ONE_DEADLINE_KEY = 'taskOne';
    public static $TASK_TWO_DEADLINE_KEY = 'taskTwo';
    public static $TASK_THREE_DEADLINE_KEY = 'taskThree';
    public static $PAYOFF_KEY = 'payoff';
    public static $TASK_TIME_LIMIT_KEY = 'timeLimit';

    public function __construct($entries = [])
    {
        parent::__construct(self::$formType, $entries, $this->getFormValidators());
    }

    /**
     * Returns the form's validators.
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    public function getFormValidators()
    {
        $validators = [];
        $validators[self::$NUMBER_SUBJECTS_KEY] = new IntegerValidator();
        $validators[self::$ALTERNATE_TASK_DEADLINE_KEY] = new CheckboxValidator();
        $validators[self::$TASK_ONE_DEADLINE_KEY] = new DateTimeValidator();
        $validators[self::$TASK_TWO_DEADLINE_KEY] = new DateTimeValidator();
        $validators[self::$TASK_THREE_DEADLINE_KEY] = new DateTimeValidator();
        $validators[self::$PAYOFF_KEY] = new IntegerValidator();
        $validators[self::$TASK_TIME_LIMIT_KEY] = new IntegerValidator();
        $validators[self::$PENALTY_RATE_KEY] = new FloatValidator();

        return $validators;
    }

    /**
     * Returns the session size.
     * @return int
     */
    public function getNumberSubjects()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$NUMBER_SUBJECTS_KEY]);
    }

    /**
     * @return bool
     */
    public function getAlternateDeadlineOption()
    {
        $entries = $this->getEntries();
        // When it's not empty and has passed validation so the option must be set to true.
        return ! empty($entries[self::$ALTERNATE_TASK_DEADLINE_KEY]);
    }

    /**
     * Returns the hard deadline (date and time) in that which each task should be completed by.
     *
     * @return string[]
     */
    public function getTaskDeadlines()
    {
        $entries = $this->getEntries();
        return [
            $entries[self::$TASK_ONE_DEADLINE_KEY], $entries[self::$TASK_TWO_DEADLINE_KEY],
            $entries[self::$TASK_THREE_DEADLINE_KEY]
        ];
    }

    /**
     * Returns the payoff for all tasks.
     *
     * @return float
     */
    public function getPayoff()
    {
        $entries = $this->getEntries();
        return floatval($entries[self::$PAYOFF_KEY]);
    }

    /**
     * Returns the number of minutes allotted for the completion of each task, in minutes.
     *
     * @return int
     */
    public function getTaskTimeLimits()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$TASK_TIME_LIMIT_KEY]);
    }

    /**
     * Returns the penalty rate.
     *
     * @return float
     */
    public function getPenaltyRate()
    {
        $entries = $this->getEntries();
        return floatval($entries[self::$PENALTY_RATE_KEY]);
    }

    /**
     * Returns the form Type
     * @return string
     */
    public static function getFormType()
    {
        return self::$formType;
    }

}