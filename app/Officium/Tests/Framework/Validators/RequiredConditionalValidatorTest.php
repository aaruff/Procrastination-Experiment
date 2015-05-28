<?php


namespace Officium\Framework\Validators;


class RequiredConditionalValidatorTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function Given_InvalidEntry_When_Validated_Should_ReturnFalse()
    {
        $condIntVal = new RequiredConditionalValidator([['pKey', new IntegerValidator(0, 10)]], 'cKey', new IntegerValidator(0, 10));
        $this->assertFalse($condIntVal->validate(['pKey'=>2, 'cKey'=>11]));
        $this->assertFalse($condIntVal->validate(['pKey'=>'a', 'cKey'=>'a']));
        $this->assertFalse($condIntVal->validate(['pKey'=>'a', 'cKey'=>1]));
        $this->assertFalse($condIntVal->validate(['pKey'=>2, 'cKey'=>'a']));
    }

    /**
     * @test
     */
    public function Given_ValidEntry_When_Validated_Should_ReturnTrue()
    {
        $condIntVal = new RequiredConditionalValidator([['pKey', new IntegerValidator(0, 10)]], 'cKey', new IntegerValidator(0, 10));
        $this->assertTrue($condIntVal->validate(['pKey'=>2, 'cKey'=>1]));
    }

}
