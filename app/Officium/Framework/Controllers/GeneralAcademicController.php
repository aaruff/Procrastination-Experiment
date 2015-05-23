<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\GeneralAcademicMap as Map;
use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\IncomingSurveys\GeneralAcademicSurveyForm as Form;
use Slim\Slim;

class GeneralAcademicController
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

        $subject = Session::getSubject();
        $form->save(Session::getUser());

        $subject->setNextState();
        $subject->save();

        $app->redirect(Map::toUri());
    }
}