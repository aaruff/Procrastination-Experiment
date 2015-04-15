<?php

namespace Officium\Experiment\Survey;

use Officium\Framework\Models\FormModel;

class ExternalObligationSurvey extends FormModel
{
    public function __construct($entries)
    {
        $keys = [];
        parent::__construct($keys, $entries);
    }

    /**
     * Validates the survey against the provided entries.
     *
     * @return boolean
     */
    public function validate()
    {
        // TODO: Implement validate() method.
    }
}
