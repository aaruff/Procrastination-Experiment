<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\IncomingSurveys\SubjectDeadlineForm as Form;
use Slim\Slim;
use Officium\Framework\Maps\DeadlineMap as Map;

class DeadlineController
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

        // Update state and move on
        $app->redirect(Map::toUri());
    }
}