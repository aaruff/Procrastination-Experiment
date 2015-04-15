<?php
namespace Officium\Framework\Controllers;

use Officium\Experiment\Treatment;
use Officium\Framework\Maps\DashboardMap;
use \Slim\Slim;

class DashboardController
{
    public function get()
    {
        $sessions = Treatment::all();
        $app = Slim::getInstance();
        $app->render(DashboardMap::toTemplate(), ['sessions'=>$sessions]);
    }
}