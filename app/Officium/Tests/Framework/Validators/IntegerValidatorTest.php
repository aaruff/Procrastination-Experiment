<?php

namespace Framework\Validators;

use Officium\Framework\Validators\IntegerValidator;

class IntegerValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidIntegerProvided_When_Validated_Should_ReturnTrue()
    {
        $integerValidator = new IntegerValidator();
        $this->assertTrue($integerValidator->validate(2));
        $this->assertTrue($integerValidator->validate('2'));
    }

    /**
     * @test
     */
    public function Given_InvalidIntegerProvided_When_Validated_Should_ReturnTrue()
    {
        $integerValidator = new IntegerValidator();
        $this->assertFalse($integerValidator->validate(-1));
        $this->assertFalse($integerValidator->validate('-1'));
        $this->assertFalse($integerValidator->validate('100000'));
    }

}
