<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\SurveyMap;
use Officium\Framework\Maps\LoginMap;
use Officium\Framework\Models\User;
use Officium\Framework\Maps\DashboardMap;
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
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);

        $app = Slim::getInstance();

        $post = $app->request->post();

        // Error Handling
        $errors = User::validate($post);
        if ( ! empty($errors)) {
            $app->flash('errors', $errors);
            $app->response->redirect(LoginMap::toUri());
            return;
        }

        $user = User::getUser($post['login']);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;

        if ($user->isExperimenter()) {
            $app->response->redirect(DashboardMap::toUri());
            return;
        }

        $app->response->redirect(SurveyMap::toUri());
    }
}