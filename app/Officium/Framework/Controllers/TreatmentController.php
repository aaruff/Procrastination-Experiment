<?php

namespace Officium\Framework\Controllers;

use Slim\Slim;
use Officium\Framework\Maps\LoginMap;
use Officium\Experiment\Treatment\Treatment;
use Officium\Framework\Maps\TreatmentMap;
use Officium\Framework\Validators\TreatmentValidator;

class TreatmentController 
{
    /**
     * @param string $treatmentId
     */
    public function get($treatmentId = '')
    {
        $app = Slim::getInstance();

        if ( ! TreatmentValidator::isId($treatmentId) ) {
            $app->redirect(LoginMap::toUri());
            return;
        }

        $treatment = Treatment::find(intval($treatmentId));
        $rowData = [];
        foreach ($treatment->subjects as $subject) {
            $rowData[] = ['subject'=> $subject->toArray(), 'user'=> $subject->user->toArray()];
        }
        $app->render(TreatmentMap::toTemplate(), ['treatment'=> $treatment->toArray(), 'rowData'=>$rowData]);
    }
}