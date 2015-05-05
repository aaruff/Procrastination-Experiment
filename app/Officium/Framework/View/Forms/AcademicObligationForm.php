<?php

namespace Officium\Framework\View\Forms;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Validators\ArrayValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\SessionStorable;

class AcademicObligationForm extends Form implements SessionStorable
{
    private static $HOURS_COURSE_WORK = 'hours_course_work';

    private static $NUM_MINOR = 'num_minor';
    private static $MINOR_DATE_TIME = 'minor_date_time';

    private static $NUM_MAJOR = 'num_major';
    private static $MAJOR_DATE_TIME = 'major_date_time';

    private static $NUM_EXAM = 'num_exam';
    private static $EXAM_DATE_TIME = 'exam_date_time';

    public function __construct($entries = [])
    {
        parent::__construct(IncomingSurveyState::ACADEMIC_OBLIGATION, $entries, $this->getFormValidators());
    }

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        $validators = [];
        $validators[self::$HOURS_COURSE_WORK] = new IntegerValidator();
        $validators[self::$NUM_MINOR] = new IntegerValidator();
        $validators[self::$NUM_MAJOR] = new IntegerValidator();
        $validators[self::$NUM_EXAM] = new IntegerValidator();
        $validators[self::$MINOR_DATE_TIME] = new ArrayValidator(new DateTimeValidator());
        $validators[self::$MAJOR_DATE_TIME] = new ArrayValidator(new DateTimeValidator());
        $validators[self::$EXAM_DATE_TIME] = new ArrayValidator(new DateTimeValidator());

        return $validators;
    }

    /**
     * Stores properties to the session.
     *
     * @return void
     */
    public function saveToSession()
    {
        // TODO: Implement saveToSession() method.
    }
}