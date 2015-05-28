<?php

namespace Officium\Experiment;


use Illuminate\Database\Eloquent\Model;

class CertificateSurvey extends Model
{
    protected $table = 'certificate_surveys';

    /* ------------------------------------------------------------------------------------------
     *                                Eloquent Relations
     * ------------------------------------------------------------------------------------------ */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(get_class(new Subject()), 'subject_id');
    }


    /* ------------------------------------------------------------------------------------------
     *                                      Public
     * ------------------------------------------------------------------------------------------ */
    public function setSubjectId($subjectId)
    {
        $this->subject_id = $subjectId;
    }

    /**
     * @param int $certificates
     */
    public function setCertificatesYear($certificates)
    {
        $this->certificates_year = $certificates;
    }

    /**
     * @param int $temptation
     */
    public function setTemptation($temptation)
    {
        $this->temptation = $temptation;
    }

    /**
     * @param int $certificates
     */
    public function setTemptationCertificatesYear($certificates)
    {
        $this->temptation_certificates_year = $certificates;
    }

    /**
     * @param int $nights
     */
    public function setNightsPerYear($nights)
    {
        $this->nights_per_year = $nights;
    }

}