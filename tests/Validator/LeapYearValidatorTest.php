<?php

namespace Andegna\PHPUnit\Validator;

use Andegna\Validator\LeapYearValidator;
use PHPUnit\Framework\TestCase;

class LeapYearValidatorTest extends TestCase
{
    public function yearDateProvider()
    {
        return [
            [-1, true], // 1 A.D
            [0, false],
            [1, false],
            [1998, false],
            [1999, true],
            [2000, false],
            [2001, false],
            [2002, false],
            [2003, true],
            [2004, false],
            [2005, false],
            [2006, false],
            [2007, true],
            [2008, false],
        ];
    }

    /**
     * @dataProvider yearDateProvider
     */
    public function testMethod($year, $expected)
    {
        $validator = new LeapYearValidator($year);

        $this->assertEquals($expected, $validator->isValid());
    }
}
