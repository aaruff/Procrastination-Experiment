<?php


namespace Framework\Validators;


use Officium\Framework\Validators\FloatValidator;

class FloatValidatorTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function Given_ValidFloatProvided_When_Validated_Should_ReturnTrue()
    {
        $floatValidator = new FloatValidator();
        $this->assertTrue($floatValidator->validate(0.0));
        $this->assertTrue($floatValidator->validate(0.01));
        $this->assertTrue($floatValidator->validate(1.00));
        $this->assertTrue($floatValidator->validate('0.0'));
        $this->assertTrue($floatValidator->validate('1.00'));
        $this->assertTrue($floatValidator->validate('0.1'));
    }

    /**
     * @test
     */
    public function Given_InvalidFloatProvided_When_Validated_Should_ReturnTrue()
    {
        $floatValidator = new FloatValidator();
        $this->assertFalse($floatValidator->validate(-1.0));
        $this->assertFalse($floatValidator->validate('-1.0'));
        $this->assertFalse($floatValidator->validate(100000000.0));
        $this->assertFalse($floatValidator->validate('100000000.0'));
    }
}
