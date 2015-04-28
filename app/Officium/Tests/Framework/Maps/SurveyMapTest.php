<?php

namespace Officium\Tests\Framwork\Maps;

use Officium\Framework\Maps\SurveyMap;

/**
 * Class SurveyRouterTest
 * @package Tests\Officium\Maps
 */
class SurveyRouterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function When_SurveyKeyDoesNotExists_FirstSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyMap::toTemplate(null));
    }

    /**
     * @test
     */
    public function When_InvalidSurveyProvided_FirstSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyMap::toTemplate('wrong!'));
    }

    /**
     * @test
     */
    public function When_SurveyValidKeyProvided_CorrespondingSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyMap::toTemplate(null));
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyMap::toTemplate('a'));
        $this->assertEquals('/pages/subject/survey/academicObligations.twig', SurveyMap::toTemplate('ao'));
        $this->assertEquals('/pages/subject/survey/externalObligations.twig', SurveyMap::toTemplate('eo'));
    }

    /**
     * @test
     */
    public function When_SurveyIdProvided_NextIdReturned()
    {
        $this->assertEquals('ao', SurveyMap::getNextSurveyId());
        $this->assertEquals('ao', SurveyMap::getNextSurveyId(null));
        $this->assertEquals('ao', SurveyMap::getNextSurveyId('a'));
        $this->assertEquals('eo', SurveyMap::getNextSurveyId('ao'));
    }
}
