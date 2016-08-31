<?php

namespace Andegna\PHPUnit\Exception;

use Andegna\Exception\InvalidDateException;

class InvalidDateExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Andegna\Exception\InvalidDateException
     * @expectedExceptionMessage Invalid date was given
     */
    public function test_exception_message()
    {
        throw new InvalidDateException();
    }

    public function test_by_catching_the_exception()
    {
        try {
            throw new InvalidDateException();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof InvalidDateException);
            $this->assertEquals($e->getMessage(), 'Invalid date was given');
        }
    }
}
