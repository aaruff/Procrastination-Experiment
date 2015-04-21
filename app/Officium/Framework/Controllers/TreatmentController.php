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
     * @param string $id
     */
    public function get($id='')
    {
        $app = Slim::getInstance();

        if ( ! TreatmentValidator::isId($id) ) {
            $app->redirect(LoginMap::toUri());
            return;
        }



        $treatment = Treatment::find(intval($id));
        $rowData = [];
        foreach ($treatment->subjects as $subject) {
            $rowData[] = ['subject'=> $subject->toArray(), 'user'=> $subject->user->toArray()];
        }
        $app->render(TreatmentMap::toTemplate(), ['treatment'=> $treatment->toArray(), 'rowData'=>$rowData]);
    }
}