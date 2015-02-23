<?php

namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Models\Experiment;
use Officium\Controllers\Experimenter\BaseController;

class Session extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->render('pages.experimenter.experiment.session');
    }

    public function post()
    {
        $postEntries = $this->getPost();

        // Error Handling
        $errors = Experiment::validate($postEntries);
        if ( ! empty($errors)) {
            var_dump($errors);
            die();
            $this->app->flash('errors', $errors);
            $this->app->redirect(Login::route());
            return;
        }
    }
}