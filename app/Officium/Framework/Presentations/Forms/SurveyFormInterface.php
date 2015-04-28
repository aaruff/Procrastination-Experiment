<?php

namespace Officium\Framework\Presentations\Forms;


interface SurveyFormInterface extends FormInterface
{
    /**
     * Stores the survey form entries.
     *
     * @return null
     */
    public function saveToSession();
}