<?php
namespace Officium\Controllers;

class BaseController
{
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