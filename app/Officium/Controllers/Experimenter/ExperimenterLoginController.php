<?php

namespace Officium\Controllers\Experimenter;

use Officium\Controllers\Experimenter\Experiment\DashboardController;
use Officium\Models\Experimenter;

/**
 * The Experimenter Login Controller
 *
 * Class Login
 * @package Officium\Controllers\Experimenter
 */
class ExperimenterLoginController extends ExperimenterBaseController
{
    /**
     * Handles the login get request.
     */
    public function get()
    {
        $this->logout();
        $this->app->render('/pages/experimenter/login.twig');
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $post = $this->request->post();

        // Error Handling
        $errors = Experimenter::validate($post);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(ExperimenterLoginController::route());
            return;
        }

        $experimenter = Experimenter::where('login', '=', $post['login'])
            ->where('password', '=', sha1($post['password']))->first();

        $this->login($experimenter);
        $this->response->redirect(DashboardController::route());
    }

    public static function route()
    {
        return '/experimenter/login';
    }
}