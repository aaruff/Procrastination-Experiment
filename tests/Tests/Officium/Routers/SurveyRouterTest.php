<?php

namespace Tests\Officium\Routers;

use Officium\Routers\SurveyRouter;

class SurveyRouterTest extends \PHPUnit_Framework_TestCase {

    public function test_WhenSurveyKeyDoesNotExists_FirstSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute(null));
    }

    public function test_WhenInvalidSurveyProvided_FirstSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute('wrong!'));
    }

    public function test_WhenSurveyValidKeyProvided_CorrespondingSurveyTemplateRouteReturned()
    {
        $this->assertEquals('/pages/subject/survey/academic.twig', SurveyRouter::getTemplateRoute('a'));
        $this->assertEquals('/pages/subject/survey/academicObligations.twig', SurveyRouter::getTemplateRoute('ao'));
        $this->assertEquals('/pages/subject/survey/externalObligations.twig', SurveyRouter::getTemplateRoute('eo'));
    }
}
