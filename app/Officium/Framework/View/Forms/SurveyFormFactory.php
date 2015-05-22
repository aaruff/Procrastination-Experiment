<?php

namespace Officium\Framework\View\Forms;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Models\Session;
use Officium\Framework\View\Forms\IncomingSurveys\AttentiveRankSurveyForm;
use Officium\Framework\View\Forms\IncomingSurveys\GeneralAcademicSurveyForm;
use Officium\Framework\View\Forms\IncomingSurveys\AcademicObligationForm;
use Officium\Framework\View\Forms\IncomingSurveys\ExternalObligationSurveyForm;
use Officium\Framework\View\Forms\IncomingSurveys\CertificateSurveyForm;

class SurveyFormFactory 
{
    /**
     * @return SurveyForm
     */
    public static function make() {
        if (IncomingSurveyState::isGeneralAcademicState()) {
            return new GeneralAcademicSurveyForm();
        }
        else if (IncomingSurveyState::isAcademicObligationState()) {
            return new AcademicObligationForm();
        }
        else if (IncomingSurveyState::isExternalObligationState()) {
            return new ExternalObligationSurveyForm();
        }
        else if (IncomingSurveyState::isAttentiveRankState()) {
            return new AttentiveRankSurveyForm();
        }
        else if (IncomingSurveyState::isCertificateState()) {
            return new CertificateSurveyForm();
        }
    }

    /**
     * @return SurveyForm[]
     */
    public static function getAll()
    {
        return [
            IncomingSurveyState::GENERAL => new GeneralAcademicSurveyForm(Session::getSurveyFormEntries(IncomingSurveyState::GENERAL)),
            IncomingSurveyState::ACADEMIC_OBLIGATION => new AcademicObligationForm(Session::getSurveyFormEntries(IncomingSurveyState::ACADEMIC_OBLIGATION)),
            IncomingSurveyState::EXTERNAL_OBLIGATION => new ExternalObligationSurveyForm(Session::getSurveyFormEntries(IncomingSurveyState::EXTERNAL_OBLIGATION)),
            IncomingSurveyState::ATTENTIVE_RANK => new AttentiveRankSurveyForm(Session::getSurveyFormEntries(IncomingSurveyState::ATTENTIVE_RANK)),
            IncomingSurveyState::CERTIFICATE => new CertificateSurveyForm(Session::getSurveyFormEntries(IncomingSurveyState::CERTIFICATE))
        ];
    }
}