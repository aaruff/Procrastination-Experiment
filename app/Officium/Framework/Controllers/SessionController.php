<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Presentations\Forms\SessionForm;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use \Slim\Slim;

class SessionController
{
    /**
     * Get request handler.
     */
    public function get()
    {
        $app = Slim::getInstance();
        $app->render(SessionMap::toTemplate(),$app->flashData());
    }

    /**
     * Post request handler.
     */
    public function post()
    {
        $app = Slim::getInstance();

        $sessionForm = new SessionForm($app->request->post());
        if ($sessionForm->validate()) {
            $sessionForm->createSession();
            $responseUri = DashboardMap::toUri();
        }
        else {
            $app->flash('flash', $sessionForm->getEntriesWithErrors());
            $responseUri = SessionMap::toUri();
        }

        $app->redirect($responseUri);
    }
}