<?php

namespace Officium\User\Controllers;

use Officium\Experimenter\Routers\DashboardRouter;
use Officium\User\Routers\LoginRouter;
use Officium\User\Models\User;
use Officium\Subject\Routers\SurveyMap;

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

        $this->app = \Slim\Slim::getInstance();
        $this->request = $this->app->request;
        $this->response = $this->app->response;
    }

    /**
     * Handles the login get request.
     */
    public function get()
    {
        $this->app->render(LoginRouter::getTemplate());
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
            $this->response->redirect(LoginRouter::uri());
            return;
        }

        $user = User::where('login', '=', $post['login'])
            ->where('password', '=', sha1($post['password']))->first();

        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;

        if ($user->role == User::$EXPERIMENTER) {
            $this->response->redirect(DashboardRouter::uri());
        }

        $this->response->redirect(SurveyMap::toUri());
    }
}