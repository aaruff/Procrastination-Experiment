<?php
namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Models\Session as ExperimentSession;
use Officium\Controllers\Experimenter\ExperimenterBaseController;
use Officium\Controllers\Experimenter\ExperimenterLoginController as Login;

class DashboardController extends ExperimenterBaseController
{
    public function  __construct()
    {
        parent::__construct();
        if ( ! $this->isLoggedIn()) {
            $this->response->redirect(Login::route());
        }
    }

    public static function route()
    {
        return '/experiment/dashboard';
    }

    public function get()
    {
        $sessions = ExperimentSession::all();
        $this->app->render('/pages/experimenter/experiment/dashboard.twig', ['sessions'=>$sessions]);
    }
}