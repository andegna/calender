<?php

namespace Andegna\PHPUnit\Converter;

use Andegna\Converter\FromJdnConverter;

class FromJdnConverterTest extends \PHPUnit\Framework\TestCase
{
    public function invalidJDNDataProvider()
    {
        return [
            [null],
            [[4, 2, 0]],
            ['lorem ipsum'],
            [true],
            [new \stdClass()],
        ];
    }

    /**
     * @dataProvider invalidJDNDataProvider
     *
     * @expectedException \Andegna\Exception\InvalidDateException
     *
     * @param $jdn
     */
    public function test_exception_is_thrown_on_an_invalid_data($jdn)
    {
        new FromJdnConverter($jdn);
    }

    public function validJDNDataProvider()
    {
        $this->assertTrue(class_exists('Andegna\PHPUnit\Converter\ToJdnConverterTest'));

        return (new ToJdnConverterTest())
            ->validJDNDataProvider();
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
