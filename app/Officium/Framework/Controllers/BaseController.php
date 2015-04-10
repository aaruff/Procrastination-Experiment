<?php
namespace Officium\Framework\Controllers;

/**
 * Provides subclasses with convenience wrappers for the framework.
 *
 * @package Officium\Controllers\Subject
 */
class BaseController
{
    /**
     * @var null|\Slim\Slim
     */
    protected $app;
    /**
     * @var \Slim\Http\Request
     */
    protected $request;
    /**
     * @var \Slim\Http\Response
     */
    protected $response;

    /**
     * Sets up framework convenience properties
     */
    public function __construct()
    {
        $this->app = \Slim\Slim::getInstance();
        $this->request = $this->app->request;
        $this->response = $this->app->response;
    }
}