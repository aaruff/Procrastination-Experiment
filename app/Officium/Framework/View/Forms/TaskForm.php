<?php

namespace Officium\Framework\View\Forms;

use Officium\Framework\Models\Session;
use Officium\Experiment\Subject;
use Officium\Experiment\SubjectGame;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\ProblemValidator;
use Officium\Experiment\Problem;
use Slim\Slim;

class TaskForm extends Form implements Saveable
{
    protected static $DISPLAY_DATE_TIME_FORMAT = 'n/j/y g:i a';

    private static $TASK_NUMBER = 'task_number';
    private static $SOLUTION = 'solution';

    private $subject;
    private $taskNumber;
    private $problem;

    /**
     * @param Subject $subject
     * @param Problem $problem
     * @param int $taskNumber
     */
    public function __construct(Subject $subject, $taskNumber, Problem $problem)
    {
        $this->subject = $subject;
        $this->taskNumber = $taskNumber;
        $this->problem = $problem;
    }

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
        $subjectTask = $this->subject->getSubjectTask($this->taskNumber);

        $game = new SubjectGame($this->subject);
        $subjectTask->setPayoff($game->getTaskPayoff($this->taskNumber));

        $subjectTask->setCompleted(true);
        $subjectTask->setTimeCompleted(new \DateTime('now'));

        $subjectTask->save();


        if ($game->isOver()) {
            $subject = Session::getSubject();
            $subject->setNextState();
            $subject->save();
        }


        $this->flashProblemCompletionRecords($this->taskNumber);
    }

    /**
     * Returns the session start and end date time.
     * @return array
     */
    public function getFormParameters()
    {
        $session = $this->subject->getSession();
        $game = new SubjectGame($this->subject);

        $now = new \DateTime('now');

        $otherTasks = [];
        $numTasks = $game->getNumTasks();
        for ($i = 1; $i <= $numTasks; ++$i) {
            if ($i == $this->taskNumber || ! $game->isTaskAccessible($i)) {
                continue;
            }

            $task['number'] = $i;
            $task['task_deadline'] = $game->getTaskState($i);
            $task['payoff'] = $game->getTaskPayoff($i);
            $otherTasks[] = $task;
        }

        $app = Slim::getInstance();
        $phrases = $this->getAlphaArrayEntry(self::$SOLUTION);
        if (empty($phrases) && $app->config('debug')) {
            $phrases = $this->problem->getPhrases();
        }

        $errors = [];
        if( ! empty($this->getErrors())) {
            $errors = $this->getErrors();
        }

        // Get other available task deadlines and times.
        $formData = [
            'task_number'=> $this->taskNumber,
            'ctime' => $now->format('m/d/Y g:i a'),
            'taskpayoff'=>$game->getTaskPayoff($this->taskNumber),
            'task_deadline'=>$game->getDeadline($this->taskNumber),
            'problem_deadline'=>$game->getProblemDeadline($this->taskNumber),
            'start'=>$session->getStartDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'end'=>$session->getEndDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'problem_url'=>$this->problem->getImageFileName(),
            'phrases'=>$phrases,
            'other_tasks'=>$otherTasks,
            'errors'=>$errors
        ];

        return $formData;
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
        $validators[self::$SOLUTION] = new ProblemValidator($this->problem->getPhrases());
        $validators[self::$TASK_NUMBER] = new IntegerValidator(1, 100);

        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */
    /**
     * @param $taskNumber
     */
    private function flashProblemCompletionRecords($taskNumber)
    {
        $app = Slim::getInstance();

        $app->flash('dialog', true);
        $app->flash('header', "Task $taskNumber Complete");
        $app->flash('body', "Task $taskNumber problem has been successfully completed.");
        $app->flashKeep();
    }

}