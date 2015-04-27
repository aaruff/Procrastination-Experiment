<?php

namespace Officium\Framework\Presentations\Forms;

use Officium\Experiment\Subject;
use Officium\Experiment\Session;
use Officium\Experiment\Treatment\Task;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\CheckboxValidator;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\FloatValidator;
use Officium\Framework\Validators\DateTimeValidator;
use Officium\Experiment\Treatment\Treatment;

class SessionForm extends Form
{
    private static $DATE_TIME_FORMAT = 'm-d-Y g:i a';

    private static $SIZE = 'size';
    private static $ADJUSTABLE_DEADLINE = 'adjustableDeadline';
    private static $PENALTY_RATE = 'penaltyRate';
    private static $TASK_ONE_DEADLINE = 'taskOne';
    private static $TASK_TWO_DEADLINE = 'taskTwo';
    private static $TASK_THREE_DEADLINE = 'taskThree';
    private static $PAYOFF = 'payoff';
    private static $TASK_TIME_LIMIT = 'timeLimit';

    private static $NUM_TASKS = 3;


    public function __construct($entries = [])
    {
        $formType = Treatment::$THREE_TASK_TIME_LIMIT_PENALTY_ADJUSTABLE_DEADLINE;
        parent::__construct($formType, $entries, $this->getFormValidators());
    }

    /**
     * Returns the form's validators.
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    public function getFormValidators()
    {
        $validators = [];
        $validators[self::$SIZE] = new IntegerValidator();
        $validators[self::$ADJUSTABLE_DEADLINE] = new CheckboxValidator();
        $validators[self::$TASK_ONE_DEADLINE] = new DateTimeValidator();
        $validators[self::$TASK_TWO_DEADLINE] = new DateTimeValidator();
        $validators[self::$TASK_THREE_DEADLINE] = new DateTimeValidator();
        $validators[self::$PAYOFF] = new IntegerValidator();
        $validators[self::$TASK_TIME_LIMIT] = new IntegerValidator();
        $validators[self::$PENALTY_RATE] = new FloatValidator();

        return $validators;
    }

    public function createSession() {
        $session = new Session();
        $session->setSize($this->getSize());
        $session->save();

        $this->createSessionSubjects($this->createSessionUsers($session), $session);
        $this->createSessionTasks($this->createSessionTreatment($session));
    }

    /**
     * Returns the session size.
     * @return int
     */
    private function getSize()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$SIZE]);
    }

    /**
     * @return bool
     */
    private function getSecondaryDeadlineEnabled()
    {
        $entries = $this->getEntries();
        // When it's not empty and has passed validation so the option must be set to true.
        return ! empty($entries[self::$ADJUSTABLE_DEADLINE]);
    }

    /**
     * Returns the hard deadline (date and time) in that which each task should be completed by.
     *
     * @param int $number
     * @return \DateTime
     */
    private function getDeadline($number)
    {
        $entries = $this->getEntries();
        $deadlines =  [$entries[self::$TASK_ONE_DEADLINE], $entries[self::$TASK_TWO_DEADLINE],
            $entries[self::$TASK_THREE_DEADLINE]];
        return \DateTime::createFromFormat(self::$DATE_TIME_FORMAT, $deadlines[$number]);
    }

    /**
     * Returns the payoff for all tasks.
     *
     * @return float
     */
    private function getPayoff()
    {
        $entries = $this->getEntries();
        return floatval($entries[self::$PAYOFF]);
    }

    /**
     * Returns the number of minutes allotted for the completion of each task, in minutes.
     *
     * @return int
     */
    private function getTaskTimeLimit()
    {
        $entries = $this->getEntries();
        return intval($entries[self::$TASK_TIME_LIMIT]);
    }

    /**
     * Returns the penalty rate.
     *
     * @return float
     */
    private function getPenaltyRate()
    {
        $entries = $this->getEntries();
        return floatval($entries[self::$PENALTY_RATE]);
    }

    /**
     * @param Session $session
     * @return Treatment
     */
    private function createSessionTreatment(Session $session)
    {
        $treatment = new Treatment();
        $treatment->setSessionId($session->getId());
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
        $size = $this->getSize();
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
            $task->setTreatmentId($treatment->getId());
            $task->setPrimaryDeadline($this->getDeadline($task->getNumber()));
            $task->setSecondaryDeadlineEnabled($this->getSecondaryDeadlineEnabled());
            $task->setTimeLimit($this->getTaskTimeLimit());
            $task->setPayoff($this->getPayoff());
            $task->setPenaltyRate($this->getPenaltyRate());
            $task->save();
        }
    }
}