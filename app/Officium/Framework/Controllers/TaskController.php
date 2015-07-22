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
            $subject = Session::getSubject();
            $subject->setNextState();
            $subject->save();
            $app->redirect(OutgoingQuestionnaireMap::toUri());
            return;
        }

        $problem = new Problem($subject->getId());

        Session::setProblemTaskNumber($taskNumber);
        Session::setProblemSolution($problem->getPhrases());
        Session::setProblemUrl($problem->getImageFileName());

        $form = new Form($subject);
        $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters(Session::getSubject())]);
    }

    /**
     * @param $taskNumber
     */
    public function post($taskNumber)
    {
        $app = Slim::getInstance();
        $subject = Session::getSubject();

        $form = new Form();
        if ( ! $form->validate($app->request->post())) {
            EventLog::logEvent($subject, EventLog::INCORRECT_SUBMISSION, $taskNumber);

            $app->flash('flash', $form->getEntriesWithErrors());
            $app->redirect(Map::toUri($taskNumber));
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