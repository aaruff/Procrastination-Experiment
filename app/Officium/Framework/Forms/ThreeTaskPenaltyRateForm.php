<?php

namespace Officium\Framework\Forms;

use Officium\Framework\Validators\CheckboxValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\SessionSizeValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\DateTimeValidator;

class ThreeTaskPenaltyRateForm extends Form
{
    private $formType = 'task:3_timeLimit_penalty_adjustableDeadline';

    public static $SESSION_SIZE_KEY = 'size';
    public static $ADJUSTABLE_SUBJECT_DEADLINE_KEY = 'adjustableDeadline';
    public static $PENALTY_RATE_KEY = 'penaltyRate';
    public static $TASK_ONE_KEY = 'taskOne';
    public static $TASK_TWO_KEY = 'taskTwo';
    public static $TASK_THREE_KEY = 'taskThree';
    public static $PAYOFF_KEY = 'payoff';
    public static $TASK_TIME_LIMIT_KEY = 'timeLimit';

    public function __construct($entries = [])
    {
        parent::__construct($this->formType, $entries, $this->getFormValidators());
    }

    /**
     * Returns the form's validators.
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    public function getFormValidators()
    {
        $validators = [];
        $validators[self::$SESSION_SIZE_KEY] = new IntegerValidator();
        $validators[self::$ADJUSTABLE_SUBJECT_DEADLINE_KEY] = new CheckboxValidator();
        $validators[self::$TASK_ONE_KEY] = new DateTimeValidator();
        $validators[self::$TASK_TWO_KEY] = new DateTimeValidator();
        $validators[self::$TASK_THREE_KEY] = new DateTimeValidator();
        $validators[self::$PAYOFF_KEY] = new IntegerValidator();
        $validators[self::$TASK_TIME_LIMIT_KEY] = new IntegerValidator();
        $validators[self::$PENALTY_RATE_KEY] = new FloatValidator();

        return $validators;
    }

    /**
     * Returns the form keys
     *
     * @return array
     */
    public function getFormKeys()
    {
        return array_keys($this->getFormValidators());
    }
}