<?php

namespace Andegna\PHPUnit\Converter;

use Andegna\Converter\ToJdnConverter;

class ToJdnConverterTest extends \PHPUnit_Framework_TestCase
{
    public function invalidJDNDataProvider()
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
        ];
    }

    /**
     * @dataProvider invalidJDNDataProvider
     * @expectedException \Andegna\Exception\InvalidDateException
     *
     * @param $month
     * @param $day
     * @param $year
     */
    public function test_exception_is_thrown_on_an_invalid_data($month, $day, $year)
    {
        new ToJdnConverter($day, $month, $year);
    }

    public function validJDNDataProvider()
    {
        return [
            [2401443, 1855, 2, 20],
            [2402423, 1857, 10, 29],
            [2402631, 1858, 5, 22],
            [2402709, 1858, 8, 10],
            [2402972, 1859, 4, 28],
            [2403345, 1860, 5, 5],

            [1724221, 1, 1, 1],
            [1724586, 2, 1, 1],
            [1724951, 3, 1, 1],

            [1724585, 1, 13, 5],
            [1724950, 2, 13, 5],
            [1725315, 3, 13, 5],
            [1725316, 3, 13, 6],

            [2299159, 1575, 2, 6],
            [2299160, 1575, 2, 7],

            [2299161, 1575, 2, 8],
            [2299162, 1575, 2, 9],

            [2415021, 1892, 4, 23],
            [2453372, 1997, 4, 23],
            [2454720, 2000, 13, 5],

            [2415385, 1893, 4, 22],
            [2448988, 1985, 4, 22],
            [2450449, 1989, 4, 22],
            [2451910, 1993, 4, 22],
            [2453371, 1997, 4, 22],

            [2817152, 2993, 4, 14],
            [3182395, 3993, 4, 7],
            [3912880, 5993, 3, 22],
        ];
    }

    /**
     * @dataProvider validJDNDataProvider
     *
     * @param $jdn
     * @param $year
     * @param $month
     * @param $day
     */
    public function test_conversion_to_jdn($jdn, $year, $month, $day)
    {
        $converter = new ToJdnConverter($day, $month, $year);

        $this->assertEquals($jdn, $converter->getJdn());
    }
}
