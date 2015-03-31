<?php
namespace Officium\Controllers\Subject;

use Officium\Controllers\Subject\SubjectLoginController as Login;
use Officium\Models\Survey;
use Officium\Models\SurveyFactory;
use Officium\Routers\StateRouter;
use Officium\Routers\SurveyRouter;

class SurveyController extends SubjectBaseController
{
    /**
     * Handles get requests
     *
     * @param $surveyId
     */
    public function get($surveyId)
    {
        $this->app->render(SurveyRouter::getTemplateRoute($surveyId));
    }

    /**
     * Handles post requests
     *
     * @param $surveyId
     */
    public function post($surveyId)
    {
        $survey = SurveyFactory::make($surveyId);
        $this->postSurvey(new $survey($this->request->post()), $surveyId);
    }

    /**
     * Handles validation of survey posts
     *
     * @param Survey $survey
     * @param $id
     */
    private function postSurvey(Survey $survey, $id)
    {
        if ( $survey->validate()) {
            $this->app->flash('errors', $survey->getErrors());
            $this->response->redirect(Login::route());
            return;
        }

        $this->setSession($id, $survey);
        $this->response->redirect('/subject/survey/' . $id);
    }
}