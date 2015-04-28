<?php

namespace Officium\Framework\Middleware;

use Officium\Framework\Maps\LoginMap;
use Slim\Slim;
use Slim\Middleware;
use Officium\Framework\Models\Session;
use Officium\Framework\Models\User;

class SubjectRouterMiddleware extends Middleware
{
    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        $app = Slim::getInstance();
        $uri = $app->request()->getResourceUri();

        if (Session::isSubject()) {
            $subject = Session::getSubject();
            if ( $uri != GameStateMap::toUri(new GameState($subject->getState()))) {
                $app->redirect($stateUri);
                return;
            }
        }
        else if (Session::isExperimenter()) {
            $this->next->call();
        }
        else {
            $app->redirect(LoginMap::toUri());
        }
    }
}