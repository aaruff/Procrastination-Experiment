<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Framework\View\Forms\Form;
use Officium\Experiment\SubjectTask;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\DateTimeValidator;

class SubjectDeadlineForm extends Form implements Saveable
{
    protected static $DISPLAY_DATE_TIME_FORMAT = 'n/j/y g:i a';

    private static $FIRST_TASK_DEADLINE = 'first_deadline';
    private static $SECOND_TASK_DEADLINE = 'second_deadline';
    private static $THIRD_TASK_DEADLINE = 'third_deadline';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

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
            $first = $this->getSubjectTask($deadlineId);
            $first->setSubjectId($user->getSubject()->getId());
            $first->save();
        }
    }

    /**
     * Returns the session start and end date time.
     * @param User $user
     * @return array
     */
    public function getFormParameters(User $user)
    {
        $subject = $user->getSubject();
        $session = $subject->getSession();

        return [
            'start'=>$session->getStartDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'end'=>$session->getEndDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT)
        ];

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
     * @return SubjectTask
     */
    private function getSubjectTask($id) {
        $subjectDeadline = new SubjectTask();
        $subjectDeadline->setDeadline($this->getDateTime($id));
        $subjectDeadline->setTaskNumber($this->getTaskNumber($id));
        return $subjectDeadline;
    }

    private function getTaskNumber($elementId)
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