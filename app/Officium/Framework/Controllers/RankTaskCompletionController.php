<?php

namespace Officium\Framework\Controllers;

use Slim\Slim;
use Officium\Framework\Maps\RankTaskCompletionMap as Map;
use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\IncomingSurveys\RankTaskCompletionForm as Form;
use Officium\Framework\Maps\SurveyCompleteMap;



class RankTaskCompletionController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $form = new Form();
        $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $app = Slim::getInstance();
        $form = new Form();
        if ( ! $form->validate($app->request->post())) {
            $app->flash('post', $form->getEntriesWithErrors());
            $app->redirect(Map::toUri());
            return;
        }

        $form->save(Session::getUser());

        $subject = Session::getSubject();
        $subject->setNextState();
        $subject->save();

        $app->render(SurveyCompleteMap::toTemplate());
    }
}