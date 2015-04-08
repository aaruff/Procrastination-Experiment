<?php
namespace Officium\Experimenter\Controllers;

class BaseController
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
}