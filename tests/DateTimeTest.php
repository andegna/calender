<?php

namespace Andegna\PHPUnit;

use Andegna\Constants;
use Andegna\DateTime;
use Andegna\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    /** @var  DateTime */
    protected $dateTime;

    protected function setUp()
    {
        parent::setUp();

        date_default_timezone_set('Africa/Addis_Ababa');

        $this->dateTime = DateTimeFactory::of(1986, 3, 21);
    }

    public function test_my_birth_day()
    {
        $this->assertEquals(1986, $this->dateTime->getYear());
        $this->assertEquals(3, $this->dateTime->getMonth());
        $this->assertEquals(21, $this->dateTime->getDay());

        $this->assertEquals(81, $this->dateTime->getDayOfYear());
        $this->assertEquals(30, $this->dateTime->getDaysInMonth());
        $this->assertEquals(false, $this->dateTime->isLeapYear());

        $this->assertEquals('ማክሰኞ, 21-ኅዳ-1986 00:00:00 EAT',
            $this->dateTime->format(DATE_COOKIE));

        $this->assertEquals('ማክሰኞ፣ ኅዳር 21 ቀን 00:00:00 እኩለ፡ሌሊት EAT 1986 ዓ/ም',
            $this->dateTime->format(Constants::DATE_ETHIOPIAN));

        $this->assertEquals('ማክሰኞ፣ ኅዳር 21 ቀን (ማርያም) 00:00:00 እኩለ፡ሌሊት EAT 1986 (ሉቃስ) ዓ/ም',
            $this->dateTime->format(Constants::DATE_ETHIOPIAN_ORTHODOX));

        $this->assertEquals('ማክሰኞ, 21-ኅዳ-1986 00:00:00 EAT',
            $this->dateTime->format(DATE_COOKIE));
    }

    public function test_date_connector()
    {
        foreach (Constants::FORMAT_MAPPER as $format => $function) {
            $this->assertEquals($this->dateTime->{$function}(), $this->dateTime->format($format));
        }
    }

//    public function test_date_connector_more()
//    {
//        foreach (Constants::FORMAT_MAPPER as $format => $function) {
//            $this->assertEquals($this->dateTime->{$function}(), $this->dateTime->format($format));
//        }
//    }

}
