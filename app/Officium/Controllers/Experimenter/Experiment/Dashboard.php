<?php
namespace Officium\Controllers\Experimenter\Experiment;

use Illuminate\Database\Capsule\Manager as Database;
use Officium\Controllers\Experimenter\BaseController;

class Dashboard extends BaseController
{
    public function  __construct()
    {
        parent::__construct();

        if ( ! $this->isLoggedIn()) {
            $this->redirectUnauthorizedRequest();
        }
    }

    public function get()
    {
        $subjects = Database::table('subject')->get();
        $this->render('pages.experimenter.experiment.dashboard', ['subjects'=>$subjects]);
    }
}