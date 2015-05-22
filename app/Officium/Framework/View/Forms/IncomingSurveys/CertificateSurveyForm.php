<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\IncomingSurveyState;
use Officium\Framework\Models\Session;
use Officium\Framework\Models\SessionStorable;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Experiment\IncomingSurvey;

use Officium\Framework\View\Forms\Form;

class CertificateSurveyForm extends Form implements SessionStorable
{
    private static $CERTIFICATE_PER_YEAR = 'cert_per_year';
    private static $TEMPTATION = 'temptation';
    private static $TEMPTATION_CERTIFICATE_PER_YEAR = 'temp_cert_per_year';
    private static $NIGHTS_PER_YEAR = 'nights_per_year';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    /**
     * @param array $entries
     */
    public function __construct($entries = [])
    {
        parent::__construct(IncomingSurveyState::CERTIFICATE, $entries, $this->getFormValidators());
    }

    /**
     * Stores properties to the session.
     *
     * @return void
     */
    public function saveToSession()
    {
        $entries = [
            self::$CERTIFICATE_PER_YEAR=>$this->getIntEntry(self::$CERTIFICATE_PER_YEAR),
            self::$TEMPTATION=>$this->getIntEntry(self::$TEMPTATION),
            self::$TEMPTATION_CERTIFICATE_PER_YEAR=>$this->getIntEntry(self::$TEMPTATION_CERTIFICATE_PER_YEAR),
            self::$NIGHTS_PER_YEAR=>$this->getIntEntry(self::$NIGHTS_PER_YEAR),
        ];

        $surveyId = Session::getSurveyId();
        Session::storeSurveyFormEntries($surveyId, $entries);
    }

    /**
     * @param IncomingSurvey $incomingSurvey
     * @return IncomingSurvey
     */
    public function setIncomingSurveyFromEntries(IncomingSurvey $incomingSurvey)
    {
        $incomingSurvey->setCertificatesYear($this->getIntEntry(self::$CERTIFICATE_PER_YEAR));
        $incomingSurvey->setTemptation($this->getIntEntry(self::$TEMPTATION));
        $incomingSurvey->setTemptationCertificatesYear($this->getIntEntry(self::$TEMPTATION_CERTIFICATE_PER_YEAR));
        $incomingSurvey->setNightsPerYear($this->getIntEntry(self::$NIGHTS_PER_YEAR));

        return $incomingSurvey;
    }


    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getFormValidators()
    {
        $validators = [];
        $validators[self::$CERTIFICATE_PER_YEAR] = new IntegerValidator(0, 200);
        $validators[self::$TEMPTATION] = new IntegerValidator(1, 3);
        $validators[self::$TEMPTATION_CERTIFICATE_PER_YEAR] = new IntegerValidator(0, 200);
        $validators[self::$NIGHTS_PER_YEAR] = new IntegerValidator(0, 200);
        return $validators;
    }
}