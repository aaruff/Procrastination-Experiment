<?php

namespace Officium\Framework\View\Forms;

use Officium\Experiment\IncomingSurvey;
use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\View\Forms\IncomingSurveys\AcademicObligationForm;
use Officium\Framework\View\Forms\IncomingSurveys\AttentiveRankSurveyForm;
use Officium\Framework\View\Forms\IncomingSurveys\CertificateSurveyForm;
use Officium\Framework\View\Forms\IncomingSurveys\ExternalObligationSurveyForm;
use Officium\Framework\View\Forms\IncomingSurveys\GeneralAcademicSurveyForm;

class IncomingSurveyForm
{
    private $allFormEntries;

    public function __construct(array $allFormEntries)
    {
        $this->allFormEntries = $allFormEntries;
    }

    /**
     * @return IncomingSurvey
     */
    public function getIncomingSurveyModel()
    {
        $generalAcademicForm = new GeneralAcademicSurveyForm($this->allFormEntries[IncomingSurveyState::GENERAL]);
        $incomingSurvey = $generalAcademicForm->setIncomingSurveyFromEntries(new IncomingSurvey());

        $academicObligationForm = new AcademicObligationForm($this->allFormEntries[IncomingSurveyState::ACADEMIC_OBLIGATION]);
        $incomingSurvey = $academicObligationForm->setIncomingSurveyFromEntries($incomingSurvey);

        $externalObligationForm = new ExternalObligationSurveyForm($this->allFormEntries[IncomingSurveyState::EXTERNAL_OBLIGATION]);
        $incomingSurvey = $externalObligationForm->setIncomingSurveyFromEntries($incomingSurvey);

        $attentiveRankForm = new AttentiveRankSurveyForm($this->allFormEntries[IncomingSurveyState::ATTENTIVE_RANK]);
        $incomingSurvey = $attentiveRankForm->setIncomingSurveyFromEntries($incomingSurvey);

        $certificateForm = new CertificateSurveyForm($this->allFormEntries[IncomingSurveyState::CERTIFICATE]);
        return $certificateForm->setIncomingSurveyFromEntries($incomingSurvey);
    }
}