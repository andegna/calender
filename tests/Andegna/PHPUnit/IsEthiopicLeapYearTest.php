<?php

namespace Andegna\PHPUnit;

use \Andegna\Calender;


class IsEthiopicLeapYearTest extends \PHPUnit_Framework_TestCase {

    public function testMethodExists()
    {
        $this->assertTrue(method_exists(Calender::class,'isEthiopianLeapYear'));
    }

    public function methodDataProvider() {
        return [
            [-1 , true], // 1 A.D
            [0 , false],
            [1 , false],
            [1998 , false],
            [1999 , true],
            [2000 , false],
            [2001 , false],
            [2002 , false],
            [2003 , true],
            [2004 , false],
            [2005 , false],
            [2006 , false],
            [2007 , true],
            [2008 , false]
        ];
    }

    /**
     * @dataProvider methodDataProvider
     */
    public function testMethod($year , $expected)
    {
        $this->assertEquals($expected, Calender::isEthiopianLeapYear($year));
    }

}
 