<?php


namespace Officium\Tests\Subject\Models;


use Officium\Subject\Models\GeneralAcademicSurvey;

class GeneralAcademicSurveyTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function Given_MixedEntries_When_GetEntriesCalled_Then_OnlyValidEntriesReturned()
    {
        $entries = ['major'=>'foo', 'not_valid'=>'2', ''=>'2', 'number_clubs'=>'1'];
        $validEntries = ['major'=>'foo', 'gpa'=>'', 'number_courses'=>'', 'number_clubs'=>'1'];
        $survey = new GeneralAcademicSurvey($entries);
        $this->assertTrue($validEntries == $survey->getEntries());
    }

    /**
     * @test
     */
    public function Given_ValidEntries_When_ValidateCalled_Then_NoErrorsReturned()
    {
        $survey = new GeneralAcademicSurvey(['major'=>'s', 'gpa'=>'0.0', 'number_courses'=>'0', 'number_clubs'=>'0']);
        $this->assertTrue($survey->validate(), "Errors: " . implode($survey->getErrors()));
        $this->assertEquals(0, count($survey->getErrors()));

        $survey->setEntries(['major'=>'s', 'gpa'=>'0.0', 'number_courses'=>'0', 'number_clubs'=>'0']);
    }

    /**
     * @test
     */
    public function Given_InvalidEntries_When_ValidateCalled_Then_ErrorsReturned()
    {
        $survey = new GeneralAcademicSurvey(['major'=>'']);
        $this->assertFalse($survey->validate());
        $this->assertEquals(1, count($survey->getErrors()), "Errors: " . implode("|", $survey->getErrors()));
        $this->assertEquals(['major'=>'Invalid Entry'], $survey->getErrors(), "Errors: " . implode("|", $survey->getErrors()));
    }
}
