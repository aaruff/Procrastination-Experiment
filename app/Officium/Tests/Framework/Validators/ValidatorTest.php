<?php
namespace Officium\Tests\Framework\Validators;

use Respect\Validation\Validator as v;

/**
 * These tests are used to both to test the validation framework and to cement my understanding of its interface.
 *
 * @package Framework\Validation
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function Given_EmptyArrayEntries_When_NotEmptySet_Should_ReturnFalse()
    {
        $this->assertFalse(v::notEmpty()->validate([]));
    }

    /**
     * @test
     */
    public function Given_ArraySetWithValidEntry_When_Tested_Should_ReturnTrue()
    {
        $this->assertTrue(v::notEmpty()->contains('value')->validate(['value']));

        $validDateTimes = ['12-02-2015 13:00:01','10-04-2015 13:00:01', '01-04-2015 03:00:01'];
        $this->assertTrue(v::arr()->each(v::date('m-d-Y H:i:s'))->validate($validDateTimes));

        $validDateTimes = ['12-02-2015 12:00 am', '12-02-2015 1:15 pm','12-02-2015 1:15 pm'];
        $this->assertTrue(v::arr()->each(v::date('m-d-Y g:i a'))->validate($validDateTimes));
    }

    /**
     * @test
     */
    public function Given_ArraySetWithInvalidEntry_When_Tested_Should_ReturnFalse()
    {
        $this->assertFalse(v::notEmpty()->contains('not the value')->validate(['value']));

        $invalidDateTimes = [ '13-02-2015 13:00:01','0-04-2015 13:00:01', '1-04-2015 40:00:01'];
        $this->assertFalse(v::arr()->each(v::date('m-d-Y H:i:s'))->validate($invalidDateTimes));

        $this->assertFalse(v::arr()->notEmpty()->each(v::date('m-d-Y g:i a'))->validate([]));
        $this->assertFalse(v::arr()->notEmpty()->each(v::date('m-d-Y g:i a'))->validate(null));
    }


    /**
     * @test
     */
    public function Given_CheckBoxEntryGiven_When_Tested_Should_ReturnTrue()
    {
        $this->assertTrue(v::when(v::notEmpty(), v::true())->validate("on"));
    }
}
