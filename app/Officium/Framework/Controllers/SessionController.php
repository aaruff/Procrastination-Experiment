<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use Officium\Experiment\Treatment;
use Officium\Framework\Models\TreatmentBuilder;

class SessionController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get request handler.
     */
    public function get()
    {
        $this->app->render(SessionMap::toTemplate());
    }

    /**
     * Post request handler.
     */
    public function post()
    {
        $form = new ThreeTaskPenaltyRateForm($this->request->post());
        if ($form->validate()) {
            $this->app->flash('errors', $form->getErrors());
            $this->response->redirect(SessionMap::toUri());
            return;
        }

        TreatmentBuilder::make($form);
        $this->app->redirect(DashboardMap::toUri());
    }

    /**
     * @param string $id
     */
    public function show($id='')
    {
        $session = Treatment::validateId($id);
        if ( ! $session) {
            $this->response->redirect(SessionMap::toUri());
            return;
        }

        $this->app->render('/pages/experimenter/experiment/session/show.twig', ['session'=>$session, 'subjects'=>$session->subjects]);
    }
}