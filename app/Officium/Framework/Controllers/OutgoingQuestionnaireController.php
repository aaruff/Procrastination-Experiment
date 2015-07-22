<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\OutgoingQuestionnaireMap as Map;
use Officium\Framework\View\Forms\OutgoingQuestionnaireForm as Form;
use Officium\Framework\Models\Session;
use Slim\Slim;

class OutgoingQuestionnaireController
{
    public function get()
    {
        $app = Slim::getInstance();

        $form = new Form();
        $app->render(Map::toTemplate(), ['parameters'=>$form->getFormParameters()]);
    }

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

        //$app->redirect(LandingPageMap::toUri());
    }

}