<?php

namespace Officium\Framework\Controllers;


use Slim\Slim;
use Officium\Framework\Maps\AcademicObligationMap as Map;
use Officium\Framework\View\Forms\IncomingSurveys\AcademicObligationForm as Form;
use Officium\Framework\Models\Session;

class AcademicObligationController
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

        $app->redirect(Map::toUri());
    }
}