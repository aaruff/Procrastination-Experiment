<?php
namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Experimenter\Models\Session as ExperimentSession;
use Officium\Experimenter\Controllers\BaseController;
use Officium\Experimenter\Controllers\LoginController as Login;

class DashboardController extends BaseController
{
    public function  __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $sessions = ExperimentSession::all();
        $this->app->render('/pages/experimenter/experiment/dashboard.twig', ['sessions'=>$sessions]);
    }
}