<?php

namespace Officium\Framework\Middleware;

use Slim\Slim;
use Slim\Middleware;
use Officium\Framework\Models\SubjectStateRouter;
use Officium\Framework\Models\Session;

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
        // Experimenters are excluded from state routing
        if (Session::isExperimenter()) {
            $this->next->call();
        }

        $app = Slim::getInstance();
        $uri = $app->request()->getResourceUri();

        $stateRoute = SubjectStateRouter::getStateUri();
        if ( $uri != $stateRoute) {
            $app->redirect($stateRoute);
            return;
        }

        $this->next->call();
    }
}