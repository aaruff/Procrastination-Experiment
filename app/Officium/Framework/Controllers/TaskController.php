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

        EventLog::logEvent($subject, EventLog::NEW_PROBLEM_ISSUED, $taskNumber);

        $game = new SubjectGame($subject);
        if ($game->isOver()) {
            $subject->setNextState();
            $subject->save();
            $app->redirect(OutgoingQuestionnaireMap::toUri());
            return;
        }

        // Generate problem only if one doesn't exist.
        $problem = Session::getTaskProblem($taskNumber);
        if ($problem == null) {
            $problem = new Problem($taskNumber, $subject->getId());
            Session::setTaskProblem($taskNumber, $problem);
        }

        // If the problem is on hold keep the problem and release the lock.
        if ( $problem->isOnHold()) {
            $problem->releaseHold();
        }
        // Otherwise reissue the problem
        else {
            $problem->reissue();
            Session::setTaskProblem($taskNumber, $problem);
        }

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

        $problem = Session::getTaskProblem($taskNumber);
        $form = new Form($subject, $taskNumber, $problem);
        if ( ! $form->validate($app->request->post())) {
            EventLog::logEvent($subject, EventLog::INCORRECT_SUBMISSION, $taskNumber);

            $game = new SubjectGame($subject);
            if ($game->getTaskState($taskNumber) == $game::PENALIZED_PAYOFF) {
                $app->redirect(LandingPageMap::toUri());
            }

            $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
            return;
        }

        $form->save(Session::getUser());

        EventLog::logEvent($subject, EventLog::CORRECT_SUBMISSION, $taskNumber);

        $game = new SubjectGame($subject);
        if ($game->isOver()) {
            $app->redirect(OutgoingQuestionnaireMap::toUri());
        }
        else {
            $app->redirect(LandingPageMap::toUri());
        }
    }

}