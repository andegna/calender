<?php

namespace Andegna\PHPUnit;

use \Andegna\Calender;


class JDToEthiopic extends \PHPUnit_Framework_TestCase {

    public function testMethodExists()
    {
//        $this->assertTrue(method_exists('Calender','jdToEthiopian'));
    }

    public function invalidJDNProvider()
    {
        return [
            ['sdfsd'],
            [true],
            [new \stdClass()]
        ];
    }

    /**
     * @dataProvider invalidJDNProvider
     * @expectedException \PHPUnit_Framework_Error_Warning
     */
    public function testWarningOnInvalidJDN($jdn)
    {
        Calender::jdToEthiopian($jdn);
    }

    public function validDataProvider()
    {
        return (new EthiopicToJD)->validDataProvider();
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testMethod($jdn, $year, $month, $day)
    {
        $this->assertEquals("$month/$day/$year", Calender::jdToEthiopian($jdn));

        $date = Calender::jdToEthiopian($jdn,true);

        $this->assertArrayHasKey('day',$date);
        $this->assertArrayHasKey('month',$date);
        $this->assertArrayHasKey('year',$date);

        $this->assertEquals($date['day'],$day);
        $this->assertEquals($date['month'],$month);
        $this->assertEquals($date['year'],$year);


    }

}
