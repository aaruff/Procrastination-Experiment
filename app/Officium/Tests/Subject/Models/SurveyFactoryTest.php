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
        $this->isTrue(SurveyFactory::make('', []) instanceof GeneralAcademicSurvey);
        $this->isTrue(SurveyFactory::make('wrong', []) instanceof GeneralAcademicSurvey);
        $this->isInstanceOf(SurveyFactory::make(null, []) instanceof GeneralAcademicSurvey);
    }

    /**
     * @test
     */
    public function When_ValidIdProvided_CorrectSurveyReturned()
    {
        $this->isTrue(SurveyFactory::make('a', []) instanceof GeneralAcademicSurvey);
        $this->isTrue(SurveyFactory::make('ao', []) instanceof AcademicObligationSurvey);
        $this->isInstanceOf(SurveyFactory::make('eo', []) instanceof ExternalObligationSurvey);
    }
}
