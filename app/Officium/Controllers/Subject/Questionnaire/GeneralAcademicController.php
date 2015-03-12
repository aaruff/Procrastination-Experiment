<?php
/**
 * Created by PhpStorm.
 * User: aruff
 * Date: 3/12/15
 * Time: 11:57 AM
 */

namespace Officium\Controllers\Subject\Questionnaire;


use Officium\Models\Questionnaire as QuestionnaireModel;
use Officium\Controllers\BaseController;

class GeneralAcademicController extends BaseController
{
    public function __construct()
    {
        // TODO: Handle out of order, or incorrect requests for the general academic survey.
    }
    public function get()
    {
        $this->render('pages.subject.survey.academic');
    }

    public function post()
    {
        $post = Request::post();
        $errors = QuestionnaireModel::validateGeneralAcademicSurvey($post);
        if ( ! empty($errors)) {
            App::flash('errors', $errors);
            Response::redirect(Login::route());
            return;
        }

        $subject = $this->getSubject();
        foreach ($post as $name => $answer) {
            $answer = new QuestionnaireModel();
            $answer->subject_id = $subject->id;
            $answer->number = QuestionnaireModel::questionNameToNumber($name);
            $answer->answer = $answer;
            $answer->save();
        }

        $subject->status = Subject::$ACADEMIC_SECTION;
        $subject->save();

        Response::redirect('/subject/questionnaire/incoming/2');
    }

}