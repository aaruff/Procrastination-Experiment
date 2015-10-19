<?php

namespace Officium\Framework\Controllers;

use Officium\Experiment\SubjectGame;
use Officium\Framework\Maps\LandingPageMap;
use Officium\Framework\Maps\OutgoingQuestionnaireMap;
use Officium\Framework\Maps\TaskMap as Map;
use Officium\Framework\View\Forms\TaskForm as Form;
use Officium\Framework\Models\Session;
use Slim\Slim;
use Officium\Experiment\Problem;
use Officium\Experiment\EventLog;

class TaskController 
{
    /**
     * @param $taskNumber
     */
    public function get($taskNumber)
    {
        $app = Slim::getInstance();
        $subject = Session::getSubject();

        $game = new SubjectGame($subject);
        $problem = Session::getTaskProblem($taskNumber, $subject->getId());
        $payoff = $game->getTaskPayoff($taskNumber);

        /**
         * Other tasks are reissued when this one is worked on to prevent work on multiple tasks at once.
         */
        $numTasks = $game->getNumTasks();
        for ($tNumber = 1; $tNumber <= $numTasks; ++$tNumber) {
            if ($tNumber == $taskNumber) {
               continue;
            }
            $tProblem = Session::getTaskProblem($tNumber, $subject->getId());
            $tProblem->reissue();
            Session::setTaskProblem($tProblem);
        }

        // Route the subject to the landing page when the current task should be re-evaluated
        if ($game->isTaskReEvaluationRequired($taskNumber) && $problem->isInInitialState()) {
            $problem->setState(Problem::PROMPT_TO_CONTINUE);
            Session::setTaskProblem($problem);

            EventLog::logEvent($subject, EventLog::TASK_PENALTY_TRANSITION, $taskNumber, $payoff);

            $form = new Form($subject, $taskNumber, $problem);
            $form->flashProblemTransitionToPenaltyState($taskNumber);
            $app->redirect(LandingPageMap::toUri());
            return;
        }

        // Handle re-issuing of the problem
        if ($game->isTaskPayoffPenalized($taskNumber) && $problem->isInPromptToContinueState()) {
            $problem->setState(Problem::CONFIRMED);
            EventLog::logEvent($subject, EventLog::PENALIZED_TASK_CHOSEN_POST_REDIRECT, $taskNumber, $payoff);
        }
        else {
            $problem->clearSolution();
            $problem->reissue();

            if ($game->isTaskPayoffPenalized($taskNumber)) {
                EventLog::logEvent($subject, EventLog::PENALIZED_PROBLEM_ISSUED, $taskNumber, $payoff);
            }
            else {
                EventLog::logEvent($subject, EventLog::PROBLEM_ISSUED, $taskNumber, $payoff);
            }
        }

        Session::setTaskProblem($problem);

        $form = new Form($subject, $taskNumber, $problem);
        $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
    }

    /**
     * @param $taskNumber
     */
    public function post($taskNumber)
    {
        $app = Slim::getInstance();
        $subject = Session::getSubject();
        $problem = Session::getTaskProblem($taskNumber, $subject->getId());
        $form = new Form($subject, $taskNumber, $problem);
        $game = new SubjectGame($subject);
        $payoff = $game->getTaskPayoff($taskNumber);

        // Invalid Solution
        if ( ! $form->validate($app->request->post())) {
            if ($game->isTaskPayoffPenalized($taskNumber)) {
                EventLog::logEvent($subject, EventLog::INCORRECT_PENALIZED_PROBLEM_SUBMITTED, $taskNumber, $payoff, $form->getNumberPhrasesEntered());
            }
            else {
                EventLog::logEvent($subject, EventLog::INCORRECT_PROBLEM_SUBMITTED, $taskNumber, $payoff, $form->getNumberPhrasesEntered());
            }

            $problem->setSolution($form->getSolution());

            // Route the subject to the landing page when the current task should be re-evaluated
            if ($game->isTaskReEvaluationRequired($taskNumber) && $problem->isInInitialState()) {
                EventLog::logEvent($subject, EventLog::TASK_PENALTY_TRANSITION, $taskNumber, $payoff);
                $problem->setState(Problem::PROMPT_TO_CONTINUE);
                Session::setTaskProblem($problem);

                $form->flashProblemTransitionToPenaltyState($taskNumber);
                $app->redirect(LandingPageMap::toUri());
                return;
            }

            $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
            return;
        }

        $form->save(Session::getUser());

        if ($game->isTaskPayoffPenalized($taskNumber)) {
            EventLog::logEvent($subject, EventLog::CORRECT_PENALIZED_PROBLEM_SUBMITTED, $taskNumber, $payoff);
        }
        else {
            EventLog::logEvent($subject, EventLog::CORRECT_PROBLEM_SUBMITTED, $taskNumber, $payoff);
        }

        if ($game->areAllTasksComplete()) {
            EventLog::logEvent($subject, EventLog::ALL_TASKS_COMPLETED);
            $app->redirect(OutgoingQuestionnaireMap::toUri());
            return;
        }

        $app->redirect(LandingPageMap::toUri());
    }
}