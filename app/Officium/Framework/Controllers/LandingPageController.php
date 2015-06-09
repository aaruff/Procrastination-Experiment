<?php

namespace Officium\Framework\Controllers;

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

        $subject = Session::getSubject();
        $tasks = $subject->getSession()->getTreatment()->tasks;

        var_dump($tasks);
        die();
        $app->render(Map::toTemplate(), $app->flashData());
    }

}