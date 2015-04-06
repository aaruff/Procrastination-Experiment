<?php

namespace Officium\Tests\Models;

use Officium\Subject\Models\AcademicObligationSurvey;
use Officium\Subject\Models\ExternalObligationSurvey;
use Officium\Subject\Models\GeneralAcademicSurvey;
use Officium\Subject\Models\SurveyFactory;

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
