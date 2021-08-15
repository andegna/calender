<?php

namespace Andegna\PHPUnit\Converter;

use Andegna\Converter\FromJdnConverter;
use TypeError;

class FromJdnConverterTest extends ConverterTest
{
    /**
     * @dataProvider invalidJDNDataProvider
     *
     * @param $jdn
     */
    public function test_exception_is_thrown_on_an_invalid_data($jdn)
    {
        $this->expectException(TypeError::class);

        new FromJdnConverter($jdn);
    }

    /**
     * @dataProvider validJDNDataProvider
     *
     * @param $jdn
     * @param $year
     * @param $month
     * @param $day
     */
    public function test_conversion_from_jdn($jdn, $year, $month, $day)
    {
        $converter = new FromJdnConverter($jdn);

        $this->assertEquals($day, $converter->getDay());
        $this->assertEquals($month, $converter->getMonth());
        $this->assertEquals($year, $converter->getYear());
    }
}
