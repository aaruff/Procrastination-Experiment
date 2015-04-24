<?php


namespace Framework\Validators;


use Officium\Framework\Validators\AlphaNumericValidator;

class AlphaNumericValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidAlphaNum_When_Validated_Should_ReturnTrue()
    {
        $alphaNumVal = new AlphaNumericValidator();
        $this->assertTrue($alphaNumVal->validate(1));
        $this->assertTrue($alphaNumVal->validate('1'));
        $this->assertTrue($alphaNumVal->validate('a'));
        $this->assertTrue($alphaNumVal->validate('a2'));
        $this->assertTrue($alphaNumVal->validate('1a'));
    }

    /**
     * @test
     */
    public function Given_InvalidValidAlphaNum_When_Validated_Should_ReturnFalse()
    {
        $alphaNumVal = new AlphaNumericValidator();
        $this->assertFalse($alphaNumVal->validate(-1));
        $this->assertFalse($alphaNumVal->validate('$!'));
        $this->assertFalse($alphaNumVal->validate('0.1'));
        $this->assertFalse($alphaNumVal->validate(0.1));
    }
}
