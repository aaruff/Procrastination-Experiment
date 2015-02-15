<?php

namespace Officium\Controllers\Experimenter;

use Officium\Controllers\BaseController;

class Login extends BaseController {

    function __construct() {
        parent::__construct();
    }

    public function get()
    {
        $this->view('pages.experimenter.login');
    }
}