<?php

namespace Officium\Tests\Models;

use Officium\Models\AcademicObligationSurvey;
use Officium\Models\ExternalObligationSurvey;
use Officium\Models\GeneralAcademicSurvey;
use Officium\Models\SurveyFactory;

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
