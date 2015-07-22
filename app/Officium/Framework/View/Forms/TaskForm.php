<?php

namespace Officium\Framework\View\Forms;

use Officium\Framework\Models\Session;
use Officium\Experiment\Subject;
use Officium\Experiment\SubjectGame;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Models\User;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Validators\ProblemValidator;
use Slim\Slim;

class TaskForm extends Form implements Saveable
{
    protected static $DISPLAY_DATE_TIME_FORMAT = 'n/j/y g:i a';

    private static $TASK_NUMBER = 'task_number';
    private static $SOLUTION = 'solution';

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
        $subject = $user->getSubject();

        $taskNumber = $this->getIntEntry(self::$TASK_NUMBER);
        $subjectTask = $subject->getSubjectTask($taskNumber);

        $game = new SubjectGame($subject);
        $subjectTask->setPayoff($game->getTaskPayoff($taskNumber));

        $subjectTask->setCompleted(true);
        $subjectTask->setTimeCompleted(new \DateTime('now'));

        $subjectTask->save();


        if ($game->isOver()) {
            $subject = Session::getSubject();
            $subject->setNextState();
            $subject->save();
        }


        $this->flashResults($taskNumber);
    }

    /**
     * Returns the session start and end date time.
     * @param Subject $subject
     * @return array
     */
    public function getFormParameters(Subject $subject)
    {
        $session = $subject->getSession();
        $game = new SubjectGame($subject);

        $now = new \DateTime('now');

        $otherTasks = [];
        $taskNumber = Session::getProblemTaskNumber();
        $numTasks = $game->getNumTasks();
        for ($i = 1; $i <= $numTasks; ++$i) {
            if ($i == $taskNumber || ! $game->isTaskAccessible($i)) {
                continue;
            }

            $task['number'] = $i;
            $task['task_deadline'] = $game->getTaskState($i);
            $task['payoff'] = $game->getTaskPayoff($i);
            $otherTasks[] = $task;
        }



        // Get other available task deadlines and times.
        $formData = [
            'task_number'=> $taskNumber,
            'ctime' => $now->format('m/d/Y g:i a'),
            'taskpayoff'=>$game->getTaskPayoff($taskNumber),
            'task_deadline'=>$game->getDeadline($taskNumber),
            'problem_deadline'=>$game->getProblemDeadline($taskNumber),
            'start'=>$session->getStartDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'end'=>$session->getEndDateTime()->format(self::$DISPLAY_DATE_TIME_FORMAT),
            'problem_url'=>Session::getProblemUrl(),
            'phrases'=>Session::getProblemSolution(),
            'other_tasks'=>$otherTasks
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
        $validators[self::$SOLUTION] = new ProblemValidator(Session::getProblemSolution());
        $validators[self::$TASK_NUMBER] = new IntegerValidator(1, 100);

        return $validators;
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Private
     * ------------------------------------------------------------------------------------------ */
    /**
     * @param $taskNumber
     */
    private function flashResults($taskNumber)
    {
        $app = Slim::getInstance();

        $app->flash('dialog', true);
        $app->flash('header', "Task $taskNumber Complete");
        $app->flash('body', "Task $taskNumber problem has been successfully completed.");
        $app->flashKeep();
    }

}