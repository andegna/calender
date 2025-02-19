<?php

namespace Andegna\Tests\AgeCalculator;

use Andegna\AgeCalculator\AgeCalculator;
use Andegna\Exception\InvalidDateException;
use PHPUnit\Framework\TestCase;

class AgeCalculatorTest extends TestCase
{
    public function testCalculateAgeReturnsInteger()
    {
        $calculator = new AgeCalculator(1996, 1, 21);
        $age = $calculator->calculateAge();
        $this->assertEquals($age, 21);
    }

    public function testConstructorWithInvalidDateThrowsException()
    {
        $this->expectException(InvalidDateException::class);
        new AgeCalculator(2000, 14, 1);
    }

    public function testCalculateAgeThrowsExceptionForFutureDate()
    {
        $calculator = new AgeCalculator(3000, 1, 1);
        $this->expectException(InvalidDateException::class);
        $calculator->calculateAge();  
    } 
}
