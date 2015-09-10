<?php

namespace Officium\Framework\Controllers;


use Slim\Slim;
use Officium\Framework\Maps\GameOverMap as Map;

class GameOverController
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(Map::toTemplate());
    }

}