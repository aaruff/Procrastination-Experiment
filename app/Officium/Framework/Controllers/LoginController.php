<?php

namespace Officium\User\Controllers;

use Officium\Experimenter\Maps\DashboardMap;
use Officium\User\Maps\LoginMap;
use Officium\User\Models\User;
use Officium\Subject\Maps\SurveyMap;

/**
 * The Experimenter Login Controller
 *
 * Class Login
 * @package Officium\Controllers\Experimenter
 */
class LoginController
{
    private $app;
    private $request;
    private $response;

    public function __construct()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);

        $this->app = \Slim\Slim::getInstance();
        $this->request = $this->app->request;
        $this->response = $this->app->response;
    }

    /**
     * Handles the login get request.
     */
    public function get()
    {
        $this->app->render(LoginMap::toTemplate());
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $post = $this->request->post();

        // Error Handling
        $errors = User::validate($post);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(LoginMap::toUri());
            return;
        }

        $user = User::where('login', '=', $post['login'])
            ->where('password', '=', sha1($post['password']))->first();

        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;

        if ($user->role == User::$EXPERIMENTER) {
            $this->response->redirect(DashboardMap::toUri());
            return;
        }

        $this->response->redirect(SurveyMap::toUri());
    }
}