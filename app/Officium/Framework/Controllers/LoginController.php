<?php

namespace Officium\Framework\Controllers;

use Officium\Experiment\EventLog;
use Officium\Experiment\StateMapFactory;
use Officium\Experiment\Subject;
use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Models\Session;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\View\Forms\LoginForm;
use \Slim\Slim;

/**
 * The Experimenter Login Controller
 *
 * Class Login
 * @package Officium\Controllers\Experimenter
 */
class LoginController
{
    /**
     * Handles the login get request.
     */
    public function get()
    {
        Session::logoutUser();
        $app = Slim::getInstance();
        $app->render(LoginMap::toTemplate(), $app->flashData());
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        Session::logoutUser();

        $app = Slim::getInstance();
        $form = new LoginForm();

        if ( ! $form->validate($app->request->post())) {
            $app->flash('flash', $form->getEntriesWithErrors());
            $app->response->redirect(LoginMap::toUri());
            return;
        }

        $user = $form->getUser();
        Session::loginUser($user);

        if ( ! $user->isExperimenter()) {
            EventLog::logEvent($user->getSubject(), EventLog::USER_LOGIN);
        }

        if ($user->isExperimenter()) {
            $app->response->redirect(DashboardMap::toUri());
        }
        else {
            $stateMap = StateMapFactory::getStateMap(Subject::getByUserId(Session::getUserId()));
            $app->response->redirect($stateMap->getStateUri());
        }
    }

}