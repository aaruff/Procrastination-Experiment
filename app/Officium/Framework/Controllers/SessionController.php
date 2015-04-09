<?php

namespace Officium\Framework\Controllers;

use Officium\Framework\Maps\DashboardMap;
use Officium\Framework\Maps\SessionMap;
use Officium\Experiment\Treatment;
use Officium\Experiment\Subject;

class SessionController extends BaseController
{
    /**
     *
     */
    public function get()
    {
        $this->app->render(SessionMap::toTemplate());
    }

    /**
     *
     */
    public function post()
    {
        $post = $this->request->post();

        $errors = Treatment::validate($post);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(SessionMap::toUri());
            return;
        }

        $session = Treatment::create($post['']);
        $size = intval($post['size']);

        for ($i = 0; $i < $size; ++$i) {
            $subject = new Subject();
            $subject->login = $subject->generateSubjectLoginName();
            $subject->password = password_hash($session->id . $subject->login, PASSWORD_DEFAULT);
            $subject->session_id = $session->id;
            $subject->save();
        }
        $this->app->redirect(DashboardMap::toUri());
    }

    /**
     * @param string $id
     */
    public function show($id='')
    {
        $session = Treatment::validateId($id);
        if ( ! $session) {
            $this->response->redirect(SessionMap::toUri());
            return;
        }

        $this->app->render('/pages/experimenter/experiment/session/show.twig', ['session'=>$session, 'subjects'=>$session->subjects]);
    }
}