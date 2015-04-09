<?php
namespace Officium\Framework\Middleware;

use Officium\Framework\Models\Auth;
use \Slim\Middleware;
use Officium\Framework\Maps\LoginMap;

class AuthMiddleware extends Middleware
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth($_SESSION);
    }

    /**
     * Call
     *
     * Perform actions specific to this middleware and optionally
     * call the next downstream middleware.
     */
    public function call()
    {
        // Get reference to application
        $app = $this->app;

        $uri = $app->request()->getResourceUri();
        if ( ! $this->auth->isAllowedToVisit($uri)) {
            $this->app->redirect(LoginMap::toUri());
            return;
        }

        $this->next->call();
    }
}