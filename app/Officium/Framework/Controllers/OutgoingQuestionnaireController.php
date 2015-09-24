<?php

namespace Officium\Framework\Controllers;

use Officium\Experiment\EventLog;
use Officium\Framework\Maps\GameOverMap;
use Officium\Framework\Maps\OutgoingQuestionnaireMap as Map;
use Officium\Framework\View\Forms\OutgoingSurveyForm as Form;
use Officium\Framework\Models\Session;
use Slim\Slim;

class OutgoingQuestionnaireController
{
    public function get()
    {
        $app = Slim::getInstance();
        $subject = Session::getSubject();

        $form = new Form($subject);
        $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
    }

    public function post()
    {
        $app = Slim::getInstance();
        $subject = Session::getSubject();

        $form = new Form($subject);
        if ( ! $form->validate($app->request->post())) {
            $app->flash('post', $form->getEntriesWithErrors());
            $app->redirect(Map::toUri());
            return;
        }

        EventLog::logEvent($subject, EventLog::OUTGOING_QUESTIONNAIRE_COMPLETED);
        $form->save(Session::getUser());

        $app->redirect(GameOverMap::toUri());
    }

}