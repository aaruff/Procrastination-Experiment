<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Presentations\Forms\ThreeTaskPenaltyRateForm;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use Officium\Experiment\Treatment;
use Officium\Framework\Models\TreatmentBuilder;
use \Slim\Slim;

class SessionController
{
    /**
     * Get request handler.
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(SessionMap::toTemplate(),['flash'=>$app->flashData(), 'form'=>new ThreeTaskPenaltyRateForm()]);
    }

    /**
     * Post request handler.
     */
    public function post()
    {
        $app = Slim::getInstance();
        $form = new ThreeTaskPenaltyRateForm($app->request->post());
        if ( ! $form->validate()) {
            $app->flash('errors', $form->getErrors());
            $app->response->redirect(SessionMap::toUri());
            return;
        }

        TreatmentBuilder::make($form);
        $app->redirect(DashboardMap::toUri());
    }
}