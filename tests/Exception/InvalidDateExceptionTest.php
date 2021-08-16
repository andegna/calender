<?php

namespace Andegna\PHPUnit\Exception;

use Andegna\Exception\InvalidDateException;
use PHPUnit\Framework\TestCase;

class InvalidDateExceptionTest extends TestCase
{
    public function test_exception_message()
    {
        $this->expectExceptionMessage('Invalid date was given');
        $this->expectException(InvalidDateException::class);

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
