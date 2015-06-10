<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\View\Tables\LandingPageTable;
use Slim\Slim;
use Officium\Framework\Models\Session;
use Officium\Framework\Maps\LandingPageMap as Map;


class LandingPageController 
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $table = new LandingPageTable();

        $app->flash('table', $table->getData(Session::getSubject()));
        $app->render(Map::toTemplate(), $app->flashData());
    }

}