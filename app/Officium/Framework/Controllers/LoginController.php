<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\GeneralAcademicMap;
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
        $form = new LoginForm($app->request->post());

        if ( ! $form->validate()) {
            $app->flash('flash', $form->getEntriesWithErrors());
            $app->response->redirect(LoginMap::toUri());
            return;
        }

        $user = $form->getUser();
        Session::loginUser($user);

        $app->response->redirect(($user->isExperimenter()) ? DashboardMap::toUri() : GeneralAcademicMap::toUri());
    }

}