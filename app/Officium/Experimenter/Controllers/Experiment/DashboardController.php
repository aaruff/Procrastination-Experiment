<?php
namespace Officium\Experimenter\Controllers\Experiment;

use Officium\Experimenter\Controllers\BaseController;
use Officium\Experimenter\Models\Treatments;
use Officium\Experimenter\Maps\DashboardMap;

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