<?php

namespace Officium\Framework\Controllers;

use Officium\Experiment\StateMapFactory;
use Slim\Slim;
use Officium\Framework\Maps\AttentiveRankMap as Map;
use Officium\Framework\View\Forms\IncomingSurveys\AttentiveRankSurveyForm as Form;
use Officium\Framework\Models\Session;

class AttentiveRankController 
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(Map::toTemplate(), $app->flashData());
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $app = Slim::getInstance();

        $form = new Form();
        if ( ! $form->validate($app->request->post())) {
            $app->flash('flash', $form->getEntriesWithErrors());
            $app->redirect(Map::toUri());
            return;
        }

        $form->save(Session::getUser());

        $subject = Session::getSubject();
        $subject->setNextState();
        $subject->save();

        $stateMap = StateMapFactory::getStateMap($subject);
        $app->redirect($stateMap->getstateuri());
    }

}