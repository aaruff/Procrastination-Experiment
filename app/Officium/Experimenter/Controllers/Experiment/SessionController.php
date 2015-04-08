<?php

namespace Officium\Experimenter\Controllers\Experiment;

use Officium\Experimenter\Maps\DashboardMap;
use Officium\Experimenter\Maps\SessionMap;
use Officium\Subject\Models\Subject;
use Officium\Experimenter\Models\Treatment as ExperimentSession;
use Officium\Experimenter\Controllers\BaseController;

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

        $errors = ExperimentSession::validate($post);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(SessionMap::toUri());
            return;
        }

        $session = ExperimentSession::create($post);
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
        $session = ExperimentSession::validateId($id);
        if ( ! $session) {
            $this->response->redirect(SessionMap::toUri());
            return;
        }

        $this->app->render('/pages/experimenter/experiment/session/show.twig', ['session'=>$session, 'subjects'=>$session->subjects]);
    }
}