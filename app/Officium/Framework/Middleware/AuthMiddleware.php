<?php
namespace Officium\Framework\Middleware;

use Slim\Slim;
use \Slim\Middleware;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Models\Session;
use Officium\Framework\Maps\GameStateMap;
use Officium\Experiment\Subject;

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

        if (LoginMap::isUri($uri) || Session::isExperimenter()) {
            $this->next->call();
            return;
        }

        if ( ! Session::isSubject()) {
            $this->app->redirect(LoginMap::toUri());
            return;
        }

        $gameState = new GameStateMap(Subject::getByUserId(Session::getUserId()));
        $stateUri = $gameState->toUri();
        if ($uri != $stateUri) {
            $this->app->redirect($gameState->toUri());
            return;
        }

        $this->next->call();
    }
}