<?php

namespace Officium\Controllers\Subject\Questionnaire;


use Officium\Controllers\Subject\SubjectBaseController;

class AttentiveOrganizedControllerExperimenter extends SubjectBaseController
{
    public function get()
    {
        $this->render('pages.subject.survey.attentiveOrganized');
    }

}