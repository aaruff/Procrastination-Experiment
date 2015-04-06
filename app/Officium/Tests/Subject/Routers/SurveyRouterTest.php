<?php

namespace Officium\Tests\Routers;

use Officium\Subject\Routers\SurveyRouter;

/**
 * Class SurveyRouterTest
 * @package Tests\Officium\Routers
 */
class SurveyRouterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function When_SurveyKeyDoesNotExists_FirstSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute(null));
    }

    /**
     * @test
     */
    public function When_InvalidSurveyProvided_FirstSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute('wrong!'));
    }

    /**
     * @test
     */
    public function When_SurveyValidKeyProvided_CorrespondingSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute(null));
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute('a'));
        $this->assertEquals('/pages/subject/survey/academicObligations.twig', SurveyRouter::getTemplateRoute('ao'));
        $this->assertEquals('/pages/subject/survey/externalObligations.twig', SurveyRouter::getTemplateRoute('eo'));
    }

    /**
     * @test
     */
    public function When_SurveyIdProvided_NextIdReturned()
    {
        $this->assertEquals('ao', SurveyRouter::getNextSurveyId());
        $this->assertEquals('ao', SurveyRouter::getNextSurveyId(null));
        $this->assertEquals('ao', SurveyRouter::getNextSurveyId('a'));
        $this->assertEquals('eo', SurveyRouter::getNextSurveyId('ao'));
    }
}
