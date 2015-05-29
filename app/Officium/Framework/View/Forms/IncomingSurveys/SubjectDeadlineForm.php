<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Framework\View\Forms\Form;
use Officium\Experiment\SubjectDeadlineSurvey;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\DateTimeValidator;

class SubjectDeadlineForm extends Form implements Saveable
{
    private static $FIRST_TASK_DEADLINE = 'first_deadline';
    private static $SECOND_TASK_DEADLINE = 'second_deadline';
    private static $THIRD_TASK_DEADLINE = 'third_deadline';

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
     *
     * @return void
     */
    public function save(User $user)
    {
        $deadlines = [self::$FIRST_TASK_DEADLINE, self::$SECOND_TASK_DEADLINE, self::$THIRD_TASK_DEADLINE];

        foreach ($deadlines as $deadlineId) {
            $first = $this->getDeadline($deadlineId);
            $first->setSubjectId($user->getSubject()->getId());
            $first->save();
        }
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
        $validators[self::$FIRST_TASK_DEADLINE] = new DateTimeValidator(parent::$DATE_TIME_FORMAT);
        $validators[self::$SECOND_TASK_DEADLINE] = new DateTimeValidator(parent::$DATE_TIME_FORMAT);
        $validators[self::$THIRD_TASK_DEADLINE] = new DateTimeValidator(parent::$DATE_TIME_FORMAT);

        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param $id
     * @return SubjectDeadlineSurvey
     */
    private function getDeadline($id) {
        $subjectDeadline = new SubjectDeadlineSurvey();
        $subjectDeadline->setDeadline($this->getDateTime($id));
        $subjectDeadline->setTaskId($this->getTaskId($id));
        return $subjectDeadline;
    }

    private function getTaskId($elementId)
    {
        switch($elementId) {
            case self::$FIRST_TASK_DEADLINE:
                return 1;
            case self::$SECOND_TASK_DEADLINE:
                return 2;
            case self::$THIRD_TASK_DEADLINE:
                return 3;
        }
    }
}