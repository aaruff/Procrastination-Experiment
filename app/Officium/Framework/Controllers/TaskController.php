<?php

namespace Officium\Framework\Controllers;

use Officium\Experiment\SubjectGame;
use Officium\Framework\Maps\LandingPageMap;
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

        EventLog::logEvent($subject, EventLog::NEW_PROBLEM_ISSUED, $taskNumber);

        $game = new SubjectGame($subject);
        $problem = Session::getTaskProblem($taskNumber, $subject->getId());

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

            $form = new Form($subject, $taskNumber, $problem);
            $form->flashProblemTransitionToPenaltyState($taskNumber);
            $app->redirect(LandingPageMap::toUri());
            return;
        }

        // Handle re-issuing of the problem
        if ($game->isTaskPayoffPenalized($taskNumber) && $problem->isInPromptToContinueState()) {
            $problem->setState(Problem::CONFIRMED);
        }
        else {
            $problem->clearSolution();
            $problem->reissue();
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
        if ( ! $form->validate($app->request->post())) {
            EventLog::logEvent($subject, EventLog::INCORRECT_SUBMISSION, $taskNumber);

            $problem->setSolution($form->getSolution());

            $game = new SubjectGame($subject);
            // Route the subject to the landing page when the current task should be re-evaluated
            if ($game->isTaskReEvaluationRequired($taskNumber) && $problem->isInInitialState()) {
                $problem->setState(Problem::PROMPT_TO_CONTINUE);
                Session::setTaskProblem($problem);

                $form->flashProblemTransitionToPenaltyState($taskNumber);
                $app->redirect(LandingPageMap::toUri());
                return;
            }

            $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
            return;
        }

        EventLog::logEvent($subject, EventLog::CORRECT_SUBMISSION, $taskNumber);
        $form->save(Session::getUser());

        $app->redirect(LandingPageMap::toUri());
    }

}