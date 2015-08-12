<?php

namespace Andegna\PHPUnit;

use Andegna\Calender;

class EthiopicCheckDateTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodExists()
    {
        $this->assertTrue(method_exists('\Andegna\Calender', 'ethiopianCheckDate'));
    }

    public function methodDataProvider()
    {
        return [
            // invalid argument
            [null, null, null, false],
            ['x', 'y', 'z', false],
            [1, null, 'z', false],
            [1, 1, '', false],
            ['1', 1, null, false],
            ['', 1, '', false],

            // day 1 - 30
            [3, -1, 2000, false],
            [3, 0, 2000, false],
            [3, 31, 2000, false],
            [3, 32, 2000, false],

            // month 1 - 13
            [-1, 1, 2000, false],
            [0, 1, 2000, false],
            [14, 1, 2000, false],
            [15, 1, 2000, false],

            // month = 13
            [13, -1, 1999, false],
            [13, 0, 1999, false],
            [13, 7, 1999, false],
            [13, 8, 1999, false],

            // month = 13 day = 6
            [13, 6, 2000, false],
            [13, 6, 2001, false],
            [13, 6, 2002, false],
            [13, 6, 2004, false],
            [13, 6, 2006, false],

            // valid
            [1, 1, 2000, true],
            [1, 5, 2000, true],
            [1, 10, 2000, true],
            [1, 15, 2000, true],
            [1, 20, 2000, true],
            [1, 25, 2000, true],
            [1, 30, 2000, true],

            [1, 1, 2000, true],
            [4, 1, 2000, true],
            [7, 1, 2000, true],
            [9, 1, 2000, true],
            [13, 1, 2000, true],

            [13, 1, 2000, true],
            [13, 2, 2000, true],
            [13, 3, 2000, true],
            [13, 4, 2000, true],
            [13, 5, 2000, true],

            [13, 6, 1999, true],
            [13, 6, 2003, true],
            [13, 6, 2007, true],
        ];
    }

    /**
     * @dataProvider methodDataProvider
     */
    public function testMethod($month, $day, $year, $expected)
    {
        $this->assertEquals($expected, Calender::ethiopianCheckDate($month, $day, $year));
    }
}
