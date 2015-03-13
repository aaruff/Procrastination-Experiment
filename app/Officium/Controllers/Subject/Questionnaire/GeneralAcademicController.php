<?php
namespace Officium\Controllers\Subject\Questionnaire;

use Officium\Controllers\Subject\SubjectBaseController;
use Officium\Models\GeneralAcademicSurvey;
use Officium\Controllers\Subject\SubjectLoginController as Login;

class GeneralAcademicController extends SubjectBaseController
{
    private static $NO_SURVEYS_COMPLETED = 0;
    private static $GENERAL_ACADEMIC_ID = 1;

    public function __construct()
    {
        parent::__construct();
        if ( ! $this->isLoggedIn() || ! $this->isNextStage()) {
            $this->response->redirect(Login::route());
        }
    }

    public function get()
    {
        $this->app->render('/pages/subject/survey/academic.twig');
    }

    public function post()
    {
        $answers = $this->request->post();

        $errors = GeneralAcademicSurvey::validate($answers);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(Login::route());
            return;
        }

        $answer = new GeneralAcademicSurvey;
        $subject = $this->getSubject();
        $answer->setAnswers($subject, $answers);
        $answer->save();

        $subject->status = self::$GENERAL_ACADEMIC_ID;
        $subject->save();

        $this->response->redirect('/subject/questionnaire/incoming/ao');
    }

    private function isNextStage()
    {
        $subject = $this->getSubject();

        if ($subject->status == self::$NO_SURVEYS_COMPLETED) {
            return true;
        }
        else {
            return false;
        }
    }
}