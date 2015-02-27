<?php
namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Models\Session as ExperimentSession;
use Officium\Controllers\Experimenter\BaseController;

class Dashboard extends BaseController
{
    public function  __construct()
    {
        parent::__construct();

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