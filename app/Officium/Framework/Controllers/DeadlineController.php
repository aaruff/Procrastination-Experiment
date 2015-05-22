<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\View\Forms\DeadlineForm;
use Slim\Slim;
use Officium\Framework\Maps\DeadlineMap;

class DeadlineController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(DeadlineMap::toTemplate(), $app->flashData());
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $app = Slim::getInstance();

        $form = new DeadlineForm();

        if ( ! $form->validate($app->request->post())) {
            $app->flash('flash', $form->getEntriesWithErrors());
            $app->redirect(DeadlineMap::toUri());
            return;
        }

        $form->save();
        // Update state and move on
        $app->redirect(SurveyMap::toUri());
    }
}