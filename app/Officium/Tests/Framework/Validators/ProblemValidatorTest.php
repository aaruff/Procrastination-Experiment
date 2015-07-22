<?php


namespace Framework\Validators;

use Officium\Framework\Validators\ProblemValidator;


class ProblemValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function Given_ValidEntriesProvided_Validation_Should_ReturnTrue()
    {
        $validator = new ProblemValidator(['foo', 'bar', 'bin', 'baz']);
        $this->assertTrue($validator->validate(['foo', 'bar', 'bin', 'baz']));
    }

    /**
     * @test
     */
    public function Given_InvalidEntriesProvided_Validation_Should_ReturnFalse()
    {
        $validator = new ProblemValidator(['foo', 'bar', 'bin', 'baz']);
        $this->assertFalse($validator->validate([]));
        $this->assertFalse($validator->validate(['foo']));
        $this->assertFalse($validator->validate(['foo', 'bar']));
        $this->assertFalse($validator->validate(['foo', 'bar', 'bin']));
        $this->assertFalse($validator->validate(['foo', 'bar', 'bin', 'ba1']));
    }
}
