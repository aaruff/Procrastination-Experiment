<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;
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
        $app->render(SessionMap::toTemplate());
    }

    /**
     * Post request handler.
     */
    public function post()
    {
        $app = Slim::getInstance();
        $form = new ThreeTaskPenaltyRateForm($app->request->post());
        if ($form->validate()) {
            $app->flash('errors', $form->getErrors());
            $app->response->redirect(SessionMap::toUri());
            return;
        }

        TreatmentBuilder::make($form);
        $app->redirect(DashboardMap::toUri());
    }

    /**
     * @param string $id
     */
    public function show($id='')
    {
        $app = Slim::getInstance();

        $session = Treatment::validateId($id);
        if ( ! $session) {
            $app->response->redirect(SessionMap::toUri());
            return;
        }

        $app->render('/pages/experimenter/experiment/session/show.twig', ['session'=>$session, 'subjects'=>$session->subjects]);
    }
}