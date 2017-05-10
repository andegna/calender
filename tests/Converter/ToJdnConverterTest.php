<?php

namespace Andegna\PHPUnit\Converter;

use Andegna\Converter\ToJdnConverter;

class ToJdnConverterTest extends ConverterTest
{
    /**
     * @dataProvider invalidDateDataProvider
     * @expectedException \Andegna\Exception\InvalidDateException
     *
     * @param $month
     * @param $day
     * @param $year
     * @param $ignore
     */
    public function test_me_please($month, $day, $year, $ignore)
    {
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
