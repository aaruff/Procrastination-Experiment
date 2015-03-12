<?php
namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Models\Session as ExperimentSession;
use Officium\Controllers\ExperimenterBaseController;

class DashboardControllerExperimenter extends ExperimenterBaseController
{
    public function  __construct()
    {
        if ( ! $this->isLoggedIn()) {
            $this->redirectToLogin();
        }
    }

    public static function route()
    {
        return '/experiment/dashboard';
    }

    public function get()
    {
        $sessions = ExperimentSession::all();
        $this->render('pages.experimenter.experiment.dashboard', ['sessions'=>$sessions]);
    }
}