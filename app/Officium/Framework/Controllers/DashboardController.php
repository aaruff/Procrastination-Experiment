<?php
namespace Officium\Framework\Controllers;

use Officium\Experiment\Treatment;
use Officium\Framework\Maps\DashboardMap;

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