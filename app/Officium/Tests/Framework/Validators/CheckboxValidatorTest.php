<?php
namespace Framework\Validators;

use Officium\Experiment\Treatment;
use Officium\Framework\Validators\CheckboxValidator;

class CheckboxValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntryProvided_When_Validated_Should_ReturnTrue()
    {
        $checkboxValidator = new CheckboxValidator();
        $this->assertTrue($checkboxValidator->validate('on'));
    }

    /**
     * @test
     */
    public function Given_InvalidEntryProvided_When_Validated_Should_ReturnTrue()
    {
        $checkboxValidator = new CheckboxValidator(true);
        $this->assertFalse($checkboxValidator->validate('not valid'));
        $this->assertFalse($checkboxValidator->validate(''));
    }

    /**
     * @test
     */
    public function Given_InvalidDateProvided_When_Validated_Should_ReturnErrorMessage()
    {
        $checkboxValidator = new CheckboxValidator();
        $checkboxValidator->validate('not valid');
        $this->assertTrue( ! empty($checkboxValidator->getErrors()));
    }
}
