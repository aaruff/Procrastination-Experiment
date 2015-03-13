<?php
namespace Officium\Controllers\Subject\Questionnaire;

use Officium\Controllers\Subject\SubjectBaseController;
use Officium\Models\Questionnaire;
use Officium\Controllers\Subject\SubjectLoginController as Login;

class GeneralAcademicController extends SubjectBaseController
{
    private static $GENERAL_ACADEMIC_ID = 1;

    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->app->render('/pages/subject/survey/academic.twig');
    }

    public function post()
    {
        $post = $this->request->post();

        $errors = Questionnaire::validateGeneralAcademicSurvey($post);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(Login::route());
            return;
        }

        $subject = $this->getSubject();
        foreach ($post as $name => $answer) {
            $answer = new Questionnaire();
            $answer->subject_id = $subject->id;
            $answer->number = Questionnaire::questionNameToNumber($name);
            $answer->answer = $answer;
            $answer->save();
        }

        $subject->status = self::$GENERAL_ACADEMIC_ID;
        $subject->save();

        $this->response->redirect('/subject/questionnaire/incoming/ao');
    }

}