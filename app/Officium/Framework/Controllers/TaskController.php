<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\TaskMap as Map;
use Officium\Framework\View\Forms\TaskForm as Form;
use Officium\Framework\Models\Session;
use Officium\Experiment\Problem;
use Slim\Slim;


class TaskController 
{
    /**
     * Handles get requests
     */
    public function get()
    {
        $app = Slim::getInstance();

        $problem = new Problem(Session::getSubject()->getId());

        $app->flash('problem_url', $problem->getImageFileName());
        $app->flash('phrase', $problem->getPhrases());
        $app->render(Map::toTemplate(), $app->flashData());
    }

    /**
     * Handles post requests
     */
    public function post()
    {
        $app = Slim::getInstance();


        $form = new Form();
        if ( ! $form->validate($app->request->post())) {
            $app->flash('flash', $form->getEntriesWithErrors());
            $app->redirect(Map::toUri());
            return;
        }

        $form->save(Session::getUser());

        $subject = Session::getSubject();
        $subject->setNextState();
        $subject->save();

        $app->redirect(Map::toUri());
    }

}