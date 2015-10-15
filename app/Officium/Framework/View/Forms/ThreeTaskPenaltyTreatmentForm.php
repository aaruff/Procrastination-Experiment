<?php

namespace Officium\Framework\View\Forms;

use Officium\Experiment\Subject;
use Officium\Experiment\Session;
use Officium\Experiment\Task;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Experiment\Treatment;
use Officium\Framework\Validators\YesNoValidator;

class ThreeTaskPenaltyTreatmentForm extends Form implements Saveable
{
    protected static $DATE_TIME_FORMAT = 'm-d-Y g:i a';

    private static $SIZE = 'size';
    private static $ADJUSTABLE_DEADLINE = 'adjustableDeadline';
    private static $START = 'start';
    private static $END = 'end';
    private static $PENALTY_RATE = 'penaltyRate';
    private static $TASK_ONE_DEADLINE = 'taskOne';
    private static $TASK_TWO_DEADLINE = 'taskTwo';
    private static $TASK_THREE_DEADLINE = 'taskThree';
    private static $PAYOFF = 'payoff';
    private static $TASK_TIME_LIMIT = 'timeLimit';

    private static $NUM_TASKS = 3;


    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators.
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getValidators()
    {
        $validators = [];
        $validators[self::$SIZE] = new IntegerValidator();
        $validators[self::$START] = new DateTimeValidator();
        $validators[self::$END] = new DateTimeValidator();
        $validators[self::$ADJUSTABLE_DEADLINE] = new YesNoValidator();
        $validators[self::$TASK_ONE_DEADLINE] = new DateTimeValidator();
        $validators[self::$TASK_TWO_DEADLINE] = new DateTimeValidator();
        $validators[self::$TASK_THREE_DEADLINE] = new DateTimeValidator();
        $validators[self::$PAYOFF] = new IntegerValidator();
        $validators[self::$TASK_TIME_LIMIT] = new IntegerValidator();
        $validators[self::$PENALTY_RATE] = new FloatValidator();

        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * Stores the session using the session form data.
     * @param \Officium\Framework\Models\User $user
     */
    public function save(User $user) {
        $session = new Session();
        $session->setSize($this->getIntEntry(self::$SIZE));
        $session->setUserId($user->getId());
        $session->setStartDateTime($this->getStartDateTime());
        $session->setEndDateTime($this->getEndDateTime());
        $session->save();

        $this->createSessionSubjects($this->createSessionUsers($session), $session);
        $this->createSessionTasks($this->createSessionTreatment($session));
    }

    /* ------------------------------------------------------------------------------------------
     *                                   Private
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return bool
     */
    private function getAdjustableDeadline()
    {
        $entries = $this->getEntries();
        // When it's not empty and has passed validation so the option must be set to true.
        return (isset($entries[self::$ADJUSTABLE_DEADLINE]) && $entries[self::$ADJUSTABLE_DEADLINE] == 'yes');
    }

    private function getStartDateTime()
    {
        $entries = $this->getEntries();
        return \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $entries[self::$START]);
    }

    private function getEndDateTime()
    {
        $entries = $this->getEntries();
        return \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $entries[self::$END]);
    }

    /**
     * Returns the hard deadline (date and time) in that which each task should be completed by.
     *
     * @param int $taskNumber
     * @return \DateTime
     */
    private function getDeadline($taskNumber)
    {
        $entries = $this->getEntries();
        $deadlines =  [1=>$entries[self::$TASK_ONE_DEADLINE], $entries[self::$TASK_TWO_DEADLINE],
            $entries[self::$TASK_THREE_DEADLINE]];
        return \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $deadlines[$taskNumber]);
    }

    /**
     * @param Session $session
     * @return Treatment
     */
    private function createSessionTreatment(Session $session)
    {
        $treatment = new Treatment();
        $treatment->setSessionId($session->getId());
        $treatment->setTreatmentType(Treatment::$THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE);
        $treatment->save();
        return $treatment;
    }

    /**
     * @param Session $session
     * @return User[]
     */
    private function createSessionUsers(Session $session)
    {
        $users = [];
        $size = $this->getIntEntry(self::$SIZE);
        for ($i = 0; $i < $size; ++$i) {
            $user = new User();
            $user->setLogin();
            $user->setPassword($session->getId(), $user->getLogin());
            $user->setRole(Subject::getRole());
            $user->save();
            $users[] = $user;
        }

        return $users;
    }

    /**
     * @param User[] $users
     * @param Session $session
     */
    private function createSessionSubjects(array $users, Session $session)
    {
        foreach ($users as $user) {
            $subject = new Subject();
            $subject->setUserId($user->getId());
            $subject->setSessionId($session->getId());
            $subject->save();
        }
    }

    /**
     * @param Treatment $treatment
     */
    private function createSessionTasks(Treatment $treatment)
    {
        for ($i = 0; $i < self::$NUM_TASKS; ++$i) {
            $task = new Task();
            $task->setNumber($i + 1);
            $task->setTreatmentId($treatment->getId());
            $task->setPenaltyRateEnabled(true);
            $task->setPrimaryDeadline($this->getDeadline($task->getNumber()));
            $task->setSecondaryDeadlineEnabled($this->getAdjustableDeadline());
            $task->setTimeLimit($this->getIntEntry(self::$TASK_TIME_LIMIT));
            $task->setPayoff($this->getFloatEntry(self::$PAYOFF));
            $task->setPenaltyRate($this->getFloatEntry(self::$PENALTY_RATE));
            $task->save();
        }
    }
}