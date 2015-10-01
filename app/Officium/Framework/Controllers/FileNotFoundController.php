<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\FileNotFoundMap;
use \Slim\Slim;

class FileNotFoundController
{
    /**
     * Handles the login get request.
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(FileNotFoundMap::toTemplate());
    }
}