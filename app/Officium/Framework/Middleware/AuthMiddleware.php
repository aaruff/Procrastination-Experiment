<?php
namespace Officium\Framework\Middleware;

use Officium\Experiment\StateMapFactory;
use Officium\Framework\Maps\FileNotFoundMap;
use Slim\Slim;
use \Slim\Middleware;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Models\Session;
use Officium\Experiment\Subject;
use Officium\Framework\Validators\ExperimentRouteValidator;

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

        // Allow login requests, and those by the experimenter, to be handled by the framework.
        if (LoginMap::isUri($uri) || FileNotFoundMap::isUri($uri) || Session::isExperimenter()) {
            $this->next->call();
            return;
        }

        // Any request not coming from a logged in user will be redirected to the login page.
        if ( ! Session::isSubject()) {
            $app->response()->redirect(LoginMap::toUri(), 401);
            return;
        }

        $stateMap = StateMapFactory::getStateMap(Subject::getByUserId(Session::getUserId()));
        $isExperimentRoute = function () use ($app, $uri, $stateMap) {
            if ( ! ExperimentRouteValidator::isExperimentRoute($uri)) {
                throw new \Exception('Resource Not Found');
            }

            /* @var \Officium\Framework\Maps\ThreeTaskPenaltyStateMap $stateMap */
            if ( ! $stateMap->isStateValidUri($uri)) {
                $app->response()->redirect(FileNotFoundMap::toUri());
                $app->getLog()->error("Invalid Uri: " . $uri);
                throw new \Exception('Invalid URI');
            }
        };

        $app->hook('slim.before.dispatch', $isExperimentRoute);

        $this->next->call();
    }
}