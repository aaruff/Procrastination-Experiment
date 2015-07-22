<?php


namespace Framework\Validators;


use Officium\Framework\Validators\AlphabeticalValidator;

class AlphabeticalValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidAlphaStringProvided_When_Validated_Should_ReturnTrue()
    {
        $alphaValidator = new AlphabeticalValidator();
        $this->assertTrue($alphaValidator->validate('as'));
        $this->assertTrue($alphaValidator->validate('ai'));
    }

    /**
     * @test
     */
    public function Given_InvalidAlphaStringProvided_When_Validated_Should_ReturnFalse()
    {
        $alphaValidator = new AlphabeticalValidator();
        $this->assertFalse($alphaValidator->validate(''));
        $this->assertFalse($alphaValidator->validate('1'));
        $this->assertFalse($alphaValidator->validate('a1'));
        $this->assertFalse($alphaValidator->validate('1a'));
        $this->assertFalse($alphaValidator->validate('a a'));
        $this->assertFalse($alphaValidator->validate(2));
        $this->assertFalse($alphaValidator->validate('!#?'));
    }
}
