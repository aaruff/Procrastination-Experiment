<?php

namespace Officium\Controllers\Subject\Questionnaire;


use Officium\Controllers\Subject\SubjectBaseController;

class AcademicObligationController extends SubjectBaseController
{
    public function get()
    {
        $this->app->render('/pages/subject/survey/academicObligations.twig');
    }

}