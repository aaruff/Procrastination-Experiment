<?php


namespace Framework\Validators;


use Officium\Framework\Validators\ArraySumValidator;

class ArraySumValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidSum_When_Validated_Should_ReturnTrue()
    {
        $validator = new ArraySumValidator('values', 100);
        $this->assertTrue($validator->validate(['values'=>[1,99]]));
    }

    /**
     * @test
     */
    public function Given_InvalidSum_When_Validated_Should_ReturnFalse()
    {
        $validator = new ArraySumValidator('values', 100);
        $this->assertFalse($validator->validate(['values'=>[1,91]]));
    }

}
