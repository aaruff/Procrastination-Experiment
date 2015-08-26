<?php

namespace Officium\Framework\View\Forms\IncomingSurveys;

use Officium\Experiment\CertificateSurvey;
use Officium\Framework\Models\Saveable;
use Officium\Framework\Validators\IntegerValidator;
use Officium\Framework\Models\User;

use Officium\Framework\View\Forms\Form;

class CertificateForm extends Form implements Saveable
{
    private static $CERTIFICATE_PER_YEAR = 'cert_per_year';
    private static $TEMPTATION = 'temptation';
    private static $TEMPTATION_CERTIFICATE_PER_YEAR = 'temp_cert_per_year';
    private static $NIGHTS_PER_YEAR = 'nights_per_year';

    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */

    public function save(User $user)
    {
        $survey = new CertificateSurvey();
        $survey->setCertificatesYear($this->getIntEntry(self::$CERTIFICATE_PER_YEAR));
        $survey->setTemptation($this->getIntEntry(self::$TEMPTATION));
        $survey->setTemptationCertificatesYear($this->getIntEntry(self::$TEMPTATION_CERTIFICATE_PER_YEAR));
        $survey->setNightsPerYear($this->getIntEntry(self::$NIGHTS_PER_YEAR));
        $survey->setSubjectId($user->getSubject()->getId());
        $survey->save();
    }

    /* ------------------------------------------------------------------------------------------
     *                                      Protected
     * ------------------------------------------------------------------------------------------ */

    /**
     * Returns the form's validators
     *
     * @return \Officium\Framework\Validators\Validator[]
     */
    protected function getValidators()
    {
        $validators = [];
        $validators[self::$CERTIFICATE_PER_YEAR] = new IntegerValidator(0, 10);
        $validators[self::$TEMPTATION] = new IntegerValidator(1, 3);
        $validators[self::$TEMPTATION_CERTIFICATE_PER_YEAR] = new IntegerValidator(0, 10);
        $validators[self::$NIGHTS_PER_YEAR] = new IntegerValidator(0, 10);
        return $validators;
    }
}