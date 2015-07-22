<?php
namespace Officium\Framework\Middleware;

use Officium\Experiment\StateMapFactory;
use Slim\Slim;
use \Slim\Middleware;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Models\Session;
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

        /* @var \Officium\Framework\Maps\ThreeTaskPenaltyStateMap $stateMap */
        $stateMap = StateMapFactory::getStateMap(Subject::getByUserId(Session::getUserId()));
        if ( ! $stateMap->isStateValidUri($uri)) {
            $this->app->redirect($stateMap->getStateUri());
            return;
        }

        $this->next->call();
    }
}