<?php
namespace Officium\Controllers;

class BaseController
{
    protected function redirectToLogin()
    {
        $this->app->redirect(Login::route());
    }


    protected function loginResearcher($experimenter)
    {
        $_SESSION['experimenter'] = $experimenter;
    }

    protected function isResearcher()
    {
        return isset($_SESSION['experimenter']);
    }

    protected function logoutResearcher()
    {
        unset($_SESSION['experimenter']);
    }

    protected function loginSubject($subject)
    {
        $_SESSION['subject'] = $subject;
    }

    protected function getSubject()
    {
        return $_SESSION['subject'];
    }

    protected function isSubject()
    {
        return isset($_SESSION['subject']);
    }

    protected function logoutSubject()
    {
        unset($_SESSION['subject']);
    }

    /**
     * Add dot notation to paths
     * @param $template
     * @param $params
     */
    protected function render($template, $params = []){
        $view = str_replace('.', '/', $template);
        App::render($view . '.twig', $params);
    }

}