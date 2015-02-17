<?php

namespace Officium\Controllers\Experimenter;

use Valitron\Validator as Validator;
use Officium\Controllers\BaseController;
use Illuminate\Database\Capsule\Manager as Database;

class Login extends BaseController
{

    function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->render('pages.experimenter.login');
    }

    public function post()
    {
        $postEntries = $this->getPost();
        $validator = $this->getValidator($postEntries);
        if ( ! $validator->validate()) {
            $this->render('pages.experimenter.login', ['errors'=>$validator->errors()]);
        }

        $user = Database::table('experimenter')->where('login', '=', $postEntries['login'])->first();
    }

    private function getValidator($postEntries)
    {
        $validator = new Validator($postEntries);
        $validator->rule('required', ['login', 'password']);
        $validator->rule('alpha', 'login');
        $validator->rule('lengthMin', '3');
        $validator->rule('lengthMin', '30');

        return $validator;
    }
}