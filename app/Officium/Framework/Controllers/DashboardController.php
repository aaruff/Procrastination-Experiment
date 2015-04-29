<?php
namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\View\Tables\DashboardTable;
use \Slim\Slim;

class DashboardController
{
    public function get()
    {
        $app = Slim::getInstance();
        $dashboardTable = new DashboardTable();
        $app->render(DashboardMap::toTemplate(), $dashboardTable->getTableData());
    }
}