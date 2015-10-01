<?php


namespace Framework\Validators;

use Officium\Framework\Validators\ExperimentRouteValidator;


class ExperimentRouteValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidRoute_When_Validated_Should_ReturnTrue()
    {
        $validator = new ExperimentRouteValidator();
        $this->assertTrue($validator->isExperimentRoute('/session/foo/bar/baz'));
    }

    /**
     * @test
     */
    public function Given_InvalidRoute_When_Validated_Should_ReturnTrue()
    {
        $validator = new ExperimentRouteValidator();
        $this->assertFalse($validator->isExperimentRoute('/resource/foo/bar/baz'));
        $this->assertFalse($validator->isExperimentRoute('/'));
        $this->assertFalse($validator->isExperimentRoute(''));
        $this->assertFalse($validator->isExperimentRoute(1));
        $this->assertFalse($validator->isExperimentRoute(null));
        $this->assertFalse($validator->isExperimentRoute(new \stdClass()));
    }

}
