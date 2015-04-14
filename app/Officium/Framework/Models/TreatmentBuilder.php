<?php
namespace Officium\Framework\Models;

use Officium\Framework\Forms\Form;
use Officium\Framework\Forms\ThreeTaskPenaltyRateForm;
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