<?php

namespace Officium\Framework\Controllers;

use Slim\Slim;
use Officium\Framework\Maps\ExternalObligationMap as Map;
use Officium\Framework\View\Forms\IncomingSurveys\ExternalObligationForm as Form;
use Officium\Framework\Models\Session;

class ExternalObligationController 
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();

        $form = new Form();
        $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters(Session::getUser())]);
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

        $app->redirect(Map::toUri());
    }

}