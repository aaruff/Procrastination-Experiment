<?php

namespace Framework\Validators;

use Officium\Framework\Validators\BooleanValidator;

class BooleanValidatorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function Given_InvalidEntry_When_Validated_Should_ReturnFalse()
    {
        $boolValidator = new BooleanValidator();
        $this->assertFalse($boolValidator->validate('bad'));
        $this->assertFalse($boolValidator->validate('not good'));
        $this->assertFalse($boolValidator->validate('t'));
        $this->assertFalse($boolValidator->validate('f'));
    }

    /**
     * @test
     */
    public function Given_TruthyOrFalsyInput_When_Validated_Should_ReturnTrue()
    {
        $boolValidator = new BooleanValidator();
        $this->assertTrue($boolValidator->validate(true));
        $this->assertTrue($boolValidator->validate(1));
        $this->assertTrue($boolValidator->validate('1'));
        $this->assertTrue($boolValidator->validate('true'));
        $this->assertTrue($boolValidator->validate('on'));
        $this->assertTrue($boolValidator->validate('yes'));
        $this->assertTrue($boolValidator->validate(false));
        $this->assertTrue($boolValidator->validate(0));
        $this->assertTrue($boolValidator->validate('0'));
        $this->assertTrue($boolValidator->validate('false'));
        $this->assertTrue($boolValidator->validate('no'));
        $this->assertTrue($boolValidator->validate(''));
        $this->assertTrue($boolValidator->validate('-1'));
    }
}
