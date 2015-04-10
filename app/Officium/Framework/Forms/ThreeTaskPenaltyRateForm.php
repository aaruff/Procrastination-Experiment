<?php

namespace Officium\Framework\Forms;


use Officium\Framework\Validators\CheckboxValidator;
use Officium\Framework\Validators\PayoffValidator;
use Officium\Framework\Validators\SessionSizeValidator;
use Officium\Framework\Validators\PenaltyRateValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Validators\TimeLimitValidator;

class ThreeTaskPenaltyRateForm
{
    private $id = 'task:3_timeLimit_penalty_adjustableDeadline';

    public static $SESSION_SIZE_KEY = 'size';
    public static $ADJUSTABLE_SUBJECT_DEADLINE_KEY = 'adjustableDeadline';
    public static $PENALTY_RATE_KEY = 'penaltyRate';
    public static $TASK_ONE_KEY = 'taskOne';
    public static $TASK_TWO_KEY = 'taskTwo';
    public static $TASK_THREE_KEY = 'taskThree';
    public static $PAYOFF_KEY = 'payoff';
    public static $TASK_TIME_LIMIT_KEY = 'timeLimit';

    private $validators = [];
    private $keys = [];

    /**
     *
     */
    public function __construct()
    {
        $this->validators[self::$SESSION_SIZE_KEY] = new SessionSizeValidator();
        $this->validators[self::$ADJUSTABLE_SUBJECT_DEADLINE_KEY] = new CheckboxValidator();
        $this->validators[self::$TASK_ONE_KEY] = new DateTimeValidator();
        $this->validators[self::$TASK_TWO_KEY] = new DateTimeValidator();
        $this->validators[self::$TASK_THREE_KEY] = new DateTimeValidator();
        $this->validators[self::$PAYOFF_KEY] = new PayoffValidator();
        $this->validators[self::$TASK_TIME_LIMIT_KEY] = new TimeLimitValidator();
        $this->validators[self::$PENALTY_RATE_KEY] = new PenaltyRateValidator();

        $this->keys = [
            self::$SESSION_SIZE_KEY, self::$ADJUSTABLE_SUBJECT_DEADLINE_KEY, self::$TASK_ONE_KEY, self::$TASK_TWO_KEY,
            self::$TASK_THREE_KEY, self::$PAYOFF_KEY, self::$TASK_TIME_LIMIT_KEY, self::$PENALTY_RATE_KEY
        ];
    }

    /**
     * Populates and returns the form fields with the entries submitted by the client.
     * @param $entries
     * @return array
     */
    private function getFormFields($entries)
    {
        $fields = [];
        foreach ($this->keys as $key) {
            $fields[$key] = (isset($entries[$key])) ? trim($entries[$key]) : '';
        }

        return $fields;
    }

    /**
     * Validates the form entries.
     *
     * @param $entries
     */
    public function validate($entries)
    {
        $formFields = $this->getFormFields($entries);

        // TODO: parse and validate entries using the corresponding input validators.
    }
}