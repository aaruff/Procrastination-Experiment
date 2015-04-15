<?php
namespace Officium\Framework\Controllers;

use Officium\Experiment\Treatment;
use Officium\Framework\Maps\DashboardMap;
use \Slim\Slim;

class DashboardController
{
    public function get()
    {
        $treatments = Treatment::all();
        $app = Slim::getInstance();
        $app->render(DashboardMap::toTemplate(), ['treatments'=>$treatments]);
    }
}