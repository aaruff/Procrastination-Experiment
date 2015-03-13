<?php

namespace Officium\Controllers\Experimenter\Experiment;

use Officium\Models\Subject;
use Officium\Models\Session as ExperimentSession;
use Officium\Controllers\ExperimenterBaseController;

class SessionControllerExperimenter extends ExperimenterBaseController
{
    public function get()
    {
        $this->render('pages.experimenter.experiment.session.create');
    }

    public function create()
    {
        $post = Request::post();

        $errors = ExperimentSession::validate($post);
        if ( ! empty($errors)) {
            App::flash('errors', $errors);
            Response::redirect(SessionControllerExperimenter::route());
            return;
        }

        $session = ExperimentSession::create($post);
        $size = intval($post['size']);

        for ($i = 0; $i < $size; ++$i) {
            $subject = new Subject();
            $subject->login = $subject->generateLogin();
            $subject->password = password_hash($session->id . $subject->login, PASSWORD_DEFAULT);
            $subject->session_id = $session->id;
            $subject->status = Subject::$UNREGISTERED;
            $subject->save();
        }
        App::redirect(DashboardControllerExperimenter::route());
    }

    public function show($id='')
    {
        $session = ExperimentSession::validateId($id);
        if ( ! $session) {
            Response::redirect(SessionControllerExperimenter::route());
            return;
        }

        $this->render('pages.experimenter.experiment.session.show', ['session'=>$session, 'subjects'=>$session->subjects]);
    }

    public static function route()
    {
        return '/experiment/session';
    }
}