<?php

namespace Officium\Controllers\Experimenter\Experiment;


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

}