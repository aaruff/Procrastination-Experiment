<?php
namespace Officium\Controllers\Subject\Questionnaire;

use Officium\Controllers\Subject\SubjectBaseController;
use Officium\Models\GeneralAcademicSurvey;
use Officium\Controllers\Subject\SubjectLoginController as Login;

class IncomingSurveyController extends SubjectBaseController
{
    /**
     * Renders the general academic questionnaire.
     */
    public function getGeneralAcademicSurvey()
    {
        $this->app->render('/pages/subject/survey/academic.twig');
    }

    /**
     * Renders the academic obligation questionnaire.
     */
    public function getAcademicObligationSurvey()
    {
        $this->app->render('/pages/subject/survey/academic.twig');
    }

    /**
     * Processes the general academic post request.
     */
    public function postGeneralAcademicSurvey()
    {
        $answers = $this->request->post();

        $errors = GeneralAcademicSurvey::validate($answers);
        if ( ! empty($errors)) {
            $this->app->flash('errors', $errors);
            $this->response->redirect(Login::route());
            return;
        }

        $questionnaire = new GeneralAcademicSurvey;
        $questionnaire->setAnswers($answers);
        $this->setSession(get_class($questionnaire), $questionnaire);

        $this->response->redirect('/subject/questionnaire/ao');
    }
}