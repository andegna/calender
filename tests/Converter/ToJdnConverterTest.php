<?php

namespace Andegna\PHPUnit\Converter;

use Andegna\Converter\ToJdnConverter;
use Andegna\Exception\InvalidDateException;
use TypeError;

class ToJdnConverterTest extends ConverterTest
{
    /**
     * @dataProvider invalidDateDataProvider
     *
     * @param $month
     * @param $day
     * @param $year
     * @param $ignore
     */
    public function test_me_please($month, $day, $year, $ignore)
    {
        $this->expectException(TypeError::class);

        new ToJdnConverter($day, $month, $year);
    }

    /**
     * @dataProvider illegalDateDataProvider
     *
     * @param $month
     * @param $day
     * @param $year
     * @param $ignore
     */
    public function test_me_too($month, $day, $year, $ignore)
    {
        $this->expectException(InvalidDateException::class);

        new ToJdnConverter($day, $month, $year);
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
