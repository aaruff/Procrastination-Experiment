<?php
namespace Officium\Controllers\Experimenter;

use Officium\Controllers\BaseController;

class ExperimenterBaseController extends BaseController
{
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