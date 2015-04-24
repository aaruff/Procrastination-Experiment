<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Models\Session;
use Officium\Framework\Models\User;
use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Presentations\Forms\LoginForm;
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
        $app = Slim::getInstance();
        $app->render(LoginMap::toTemplate());
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        Session::logoutUser();

        // Get Request
        $app = Slim::getInstance();
        $form = new LoginForm($app->request->post());
        if ( $form->validate()) {
            $app->flash('errors', $form->getErrors());
            $app->response->redirect(LoginMap::toUri());
            return;
        }

        $user = User::getByLogin($form->getLogin());
        Session::loginUser($user);
        if ($user->isExperimenter()) {
            $app->response->redirect(DashboardMap::toUri());
            return;
        }

        $app->response->redirect(SurveyMap::toUri());
    }
}