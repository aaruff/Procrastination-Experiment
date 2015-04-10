<?php

namespace Officium\Tests\Models;

use Officium\Experiment\Survey\AcademicObligationSurvey;
use Officium\Experiment\Survey\ExternalObligationSurvey;
use Officium\Experiment\Survey\GeneralAcademicSurvey;
use Officium\Experiment\Survey\SurveyFactory;

/**
 * Class SurveyFactoryTest
 * @package Tests\Officium\Models
 */
class SurveyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function When_AnInvalidSurveyIDProvided_NullReturned()
    {
        $this->assertTrue(SurveyFactory::make('', []) instanceof GeneralAcademicSurvey);
        $this->assertTrue(SurveyFactory::make('wrong', []) instanceof GeneralAcademicSurvey);
        $this->assertTrue(SurveyFactory::make(null, []) instanceof GeneralAcademicSurvey);
    }

    /**
     * @test
     */
    public function When_ValidIdProvided_CorrectSurveyReturned()
    {
        $this->assertTrue(SurveyFactory::make('a', []) instanceof GeneralAcademicSurvey);
        $this->assertTrue(SurveyFactory::make('ao', []) instanceof AcademicObligationSurvey);
        $this->assertTrue(SurveyFactory::make('eo', []) instanceof ExternalObligationSurvey);
    }
}
