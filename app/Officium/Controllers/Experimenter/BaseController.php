<?php
namespace Officium\Controllers\Experimenter;

class BaseController {
    protected $app;

    public function __construct() {
        global $app;
        $this->app = $app;
    }

    protected function redirectToLogin()
    {
        $this->app->redirect(Login::route());
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

    /**
     * Add dot notation to paths
     * @param $template
     * @param $params
     */
    protected function render($template, $params = []){
        $view = str_replace('.', '/', $template);
        $this->app->render($view . '.twig', $params);
    }

    protected function getPost($key = null, $default = null)
    {
        return $this->app->request->post($key, $default);
    }

}