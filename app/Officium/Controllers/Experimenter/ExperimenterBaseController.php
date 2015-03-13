<?php
namespace Officium\Controllers\Experimenter;

use Officium\Controllers\BaseController;

class ExperimenterBaseController extends BaseController
{
    protected $app;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->request = $this->app->request;
        $this->response = $this->app->response;
    }

    protected function login($experimenter)
    {
        $_SESSION['experimenter'] = $experimenter;
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['experimenter']);
    }

    protected function logout()
    {
        unset($_SESSION['experimenter']);
    }
}