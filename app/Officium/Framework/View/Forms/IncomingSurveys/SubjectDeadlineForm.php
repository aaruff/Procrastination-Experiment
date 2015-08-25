<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Framework\Validators\TaskDeadlineValidator;
use Officium\Framework\View\Forms\Form;
use Officium\Experiment\SubjectTask;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Framework\Models\Session;

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

        /* @var $tasks \Officium\Experiment\Task[]*/
        $tasks = $subject->getSession()->getTreatment()->getTasks();

        return [
            'start'=>$session->getStartDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'end'=>$session->getEndDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            self::$FIRST_TASK_DEADLINE=>$tasks[0]->getDeadline()->format('m/d/Y g:i a'),
            self::$SECOND_TASK_DEADLINE=>$tasks[1]->getDeadline()->format('m/d/Y g:i a'),
            self::$THIRD_TASK_DEADLINE=>$tasks[2]->getDeadline()->format('m/d/Y g:i a')
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

        $subject = Session::getUser()->getSubject();
        $deadlines = [self::$FIRST_TASK_DEADLINE, self::$SECOND_TASK_DEADLINE, self::$THIRD_TASK_DEADLINE];

        $validators[self::$SEMANTIC_VALIDATORS] = [
            self::$FIRST_TASK_DEADLINE => new TaskDeadlineValidator($subject, self::$FIRST_TASK_DEADLINE, 1),
            self::$SECOND_TASK_DEADLINE => new TaskDeadlineValidator($subject, self::$SECOND_TASK_DEADLINE, 2),
            self::$THIRD_TASK_DEADLINE => new TaskDeadlineValidator($subject, self::$THIRD_TASK_DEADLINE, 3)
        ];


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