<?php

namespace Framework\Validators;

use Officium\Framework\Validators\YesNoValidator;

class YesNoValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntry_When_Validated_Should_ReturnTrue()
    {
        $boolValidator = new YesNoValidator();
        $this->assertTrue($boolValidator->validate('yes'));
        $this->assertTrue($boolValidator->validate('no'));
    }

    /**
     * @test
     */
    public function Given_InvalidEntry_When_Validated_Should_ReturnFalse()
    {
        $yesNoValidator = new YesNoValidator();
        $this->assertFalse($yesNoValidator->validate('bad'));
        $this->assertFalse($yesNoValidator->validate('not good'));
        $this->assertFalse($yesNoValidator->validate('t'));
        $this->assertFalse($yesNoValidator->validate('f'));
    }
}
