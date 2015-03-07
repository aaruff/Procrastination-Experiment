<?php

namespace Officium\Controllers\Subject;

use Officium\Controllers\BaseController;
use Officium\Models\Questionnaire as QuestionnaireModel;
use Officium\Models\Subject;

class Questionnaire extends BaseController
{
    public function get($sectionId = null)
    {
        if ( ! isset($sectionId)) return App::redirect('subject/login');

        if ($sectionId == Subject::$ACADEMIC_SECTION) {
            $this->render('pages.subject.survey.academic');
        }
        elseif ($sectionId == Subject::$ACADEMIC_OBLIGATION_SECTION) {
            $this->render('pages.subject.survey.academicObligations');
        }
        elseif ($sectionId == Subject::$EXTERNAL_OBLIGATION_SECTION) {
            $this->render('pages.subject.survey.externalObligations');
        }
    }

    public function post($sectionId = null)
    {
        if ( ! isset($sectionId)) return app::redirect('subject/login');
        if ( ! empty(QuestionnaireModel::validateSectionId($sectionId))) return app::redirect('subject/login');

        $post = Request::post();

        $errors = QuestionnaireModel::validate($sectionId, $post);
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