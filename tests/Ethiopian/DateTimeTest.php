<?php

namespace Andegna\PHPUnit\Ethiopian;

use Andegna\Ethiopian\DateTimeFactory;
use DateInterval;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function test_Me()
    {
        $dt1 = DateTimeFactory::of(1986, 3, 21);

        $dt2 = $dt1->add(new DateInterval('P1D'));
    }

    // Todo: needs more unit/integration test
//    public function test_this()
//    {
//        $dateTime = new BaseDateTime;
////        $edt = new DateTime($dateTime->setDate(1993, 11, 30));
//
////        $this->assertEquals($edt->getHour(), (int) $dateTime->format('H'));
////        $this->assertEquals($edt->getMinute(), (int) $dateTime->format('i'));
////        $this->assertEquals($edt->getSecond(), (int) $dateTime->format('s'));
////
////        $this->assertEquals($edt->getYear(), 1986);
////        $this->assertEquals($edt->getMonth(), 3);
////        $this->assertEquals($edt->getDay(), 21);
//
////        var_dump($edt);
////
////        $x = $edt->add(new DateInterval('P1D'));
////
////        var_dump($x);
//
////        echo $edt->toGregorian()->format('d.m.y').PHP_EOL;
//
////        $thePrvDay = $edt->add(new DateInterval('P1D'));
////        echo $thePrvDay->format('d m Y').PHP_EOL;
////        echo $thePrvDay->toGregorian()->format('d m Y').PHP_EOL;
////        echo $thePrvDay->format('d m Y').PHP_EOL;
////        $this->assertEquals($thePrvDay->getDay(), 20);
//
////        $theNxtDay = $edt->add(new DateInterval('P1D'));
////        $this->assertEquals($theNxtDay->getDay(), 22);
//
////        $theNxtYear = $edt->add(new DateInterval('P1Y'));
////        $this->assertEquals($theNxtYear->getYear(), 1987);
//
////        $this->assertEquals($edt->toGregorian(), $dateTime);
//    }
}
