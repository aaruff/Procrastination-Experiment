<?php
namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Experimenter\Models\Treatments;
use Officium\Experimenter\Controllers\BaseController;
use Officium\Experimenter\Routers\DashboardMap;

class DashboardController extends BaseController
{
    public function  __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $sessions = Treatments::all();
        $this->app->render(DashboardMap::toTemplate(), ['sessions'=>$sessions]);
    }
}