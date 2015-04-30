<?php

namespace Officium\Framework\View\Forms;


use Officium\Framework\Models\SessionStorable;

class AcademicObligationForm extends Form implements SessionStorable
{
    private static $HOURS_COURSE_WORK = 'hours_course_work';

    private static $MINOR_START_DATE = 'minor_state_date';
    private static $MINOR_START_TIME = 'minor_state_time';
    private static $MINOR_END_DATE = 'minor_end_date';
    private static $MINOR_END_TIME = 'minor_end_time';

    private static $MAJOR_START_DATE = 'major_state_date';
    private static $MAJOR_START_TIME = 'major_state_time';
    private static $MAJOR_END_DATE = 'major_end_date';
    private static $MAJOR_END_TIME = 'major_end_time';

    private static $EXAM_START_DATE = 'exam_state_date';
    private static $EXAM_START_TIME = 'exam_state_time';
    private static $EXAM_END_DATE = 'exam_end_date';
    private static $EXAM_END_TIME = 'exam_end_time';

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        // TODO: Implement getFormValidators() method.
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