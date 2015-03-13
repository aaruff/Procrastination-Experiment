<?php

namespace Officium\Controllers\Experimenter;

use Officium\Controllers\Experimenter\Experiment\DashboardControllerExperimenter;
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
        $this->render('pages.experimenter.login');
    }

    /**
     * Handles the login post request.
     */
    public function post()
    {
        $post = Request::post();

        // Error Handling
        $errors = Experimenter::validate($post);
        if ( ! empty($errors)) {
            App::flash('errors', $errors);
            Response::redirect(ExperimenterLoginController::route());
            return;
        }

        $experimenter = Experimenter::where('login', '=', $post['login'])
            ->where('password', '=', sha1($post['password']))->first();

        $this->login($experimenter);
        Response::redirect(DashboardControllerExperimenter::route());
    }

    public static function route()
    {
        return '/experimenter/login';
    }
}