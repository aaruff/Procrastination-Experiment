<?php
namespace Officium\Framework\Middleware;

use Slim\Slim;
use \Slim\Middleware;
use Officium\Framework\Models\Auth;
use Officium\Framework\Maps\LoginMap;

class AuthMiddleware extends Middleware
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

        $auth = new Auth();
        if ( ! $auth->isAllowedToVisit($uri)) {
            $this->app->redirect(LoginMap::toUri());
            return;
        }

        $this->next->call();
    }
}