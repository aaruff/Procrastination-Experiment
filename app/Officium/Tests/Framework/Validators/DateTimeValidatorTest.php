<?php


namespace Framework\Validators;


use Officium\Framework\Validators\DateTimeValidator;

class DateTimeValidatorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function Given_ValidDateProvided_When_Validated_Should_ReturnTrue()
    {
        $dtValidator = new DateTimeValidator();
        $this->assertTrue($dtValidator->validate('12-05-2015 12:00 pm'));
    }

    /**
     * @test
     */
    public function Given_InvalidDateProvided_When_Validated_Should_ReturnTrue()
    {
        $dtValidator = new DateTimeValidator();
        $this->assertFalse($dtValidator->validate('99-05-2015 12:00 pm'));
    }
}
