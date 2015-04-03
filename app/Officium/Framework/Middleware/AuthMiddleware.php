<?php
namespace Officium\Framework\Middleware;


use \Slim\Middleware;
use Officium\Framework\Models\Auth;

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
            $this->app->response->status(401);
            $this->app->response->header("WWW-Authenticate", sprintf('Basic realm="Protected"'));
            return;
        }

        $this->next->call();
    }
}