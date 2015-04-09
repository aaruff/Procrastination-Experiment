<?php
namespace Officium\Experimenter\Controllers\Experiment;

use Officium\Experimenter\Controllers\BaseController;
use Officium\Experimenter\Models\Treatment;
use Officium\Experimenter\Maps\DashboardMap;

class DashboardController extends BaseController
{
    public function  __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $sessions = Treatment::all();
        $this->app->render(DashboardMap::toTemplate(), ['sessions'=>$sessions]);
    }
}