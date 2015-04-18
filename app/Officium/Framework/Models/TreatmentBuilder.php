<?php
namespace Officium\Framework\Models;

use Officium\Framework\Presentations\Form;
use Officium\Framework\Presentations\Forms\ThreeTaskPenaltyRateForm;
use Officium\Experiment\Treatment\ThreeTaskPenaltyRateTreatment;

class TreatmentBuilder
{
    public static function make(Form $form)
    {
        if ($form->getType() == ThreeTaskPenaltyRateForm::getFormType()) {
            $treatmentForm = new ThreeTaskPenaltyRateForm($form->getEntries());
            ThreeTaskPenaltyRateTreatment::create($treatmentForm);
        }
    }
}