<?php
namespace Officium\Framework\Middleware;

use Officium\Routers\SurveyRouter;
use \Slim\Middleware;


class RoutingMiddleware extends Middleware
{

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
        if ($uri === SurveyRouter::uri()) {

        }

        var_dump($app->request()->getResourceUri());
        // Run inner middleware and application
        $this->next->call();

        // Capitalize response body
        $res = $app->response;
        $body = $res->getBody();
        $res->setBody(strtoupper($body));

    }

}