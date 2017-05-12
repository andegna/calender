<?php

namespace Andegna\PHPUnit;

use Andegna\Constants;
use Andegna\Converter\ToJdnConverter;
use Andegna\DateTime;
use Andegna\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    /** @var DateTime */
    protected $dateTime;

    /** @var DateTime */
    protected $otherDateTime;

    /** @var DateTime */
    protected $yetAnotherDateTime;

    protected function setUp()
    {
        parent::setUp();

        date_default_timezone_set('Africa/Addis_Ababa');

        $this->dateTime = DateTimeFactory::of(1986, 3, 21);
        $this->otherDateTime = new DateTime($this->dateTime->toGregorian()->add(new \DateInterval('P2Y4DT6H8M')));
        $this->yetAnotherDateTime = DateTimeFactory::of(2000, 1, 1)->sub(new \DateInterval('PT1H'));
    }

    public function test_my_birth_day()
    {
        $this->assertEquals(1986, $this->dateTime->getYear());
        $this->assertEquals(3, $this->dateTime->getMonth());
        $this->assertEquals(21, $this->dateTime->getDay());

        $this->assertEquals(81, $this->dateTime->getDayOfYear());
        $this->assertEquals(30, $this->dateTime->getDaysInMonth());
        $this->assertEquals(false, $this->dateTime->isLeapYear());

        $this->assertEquals(2, $this->dateTime->getDayOfWeek());
        $this->assertEquals(754606800, $this->dateTime->getTimestamp());
        $this->assertEquals(10800, $this->dateTime->getOffset());
        $this->assertEquals('Africa/Addis_Ababa', $this->dateTime->getTimezone()->getName());

        $this->assertEquals('ማክሰኞ, 21-ኅዳ-1986 00:00:00 EAT',
            $this->dateTime->format(DATE_COOKIE));

        $this->assertEquals('ማክሰኞ፣ ኅዳር 21 ቀን 00:00:00 እኩለ፡ሌሊት EAT 1986 ዓ/ም',
            $this->dateTime->format(Constants::DATE_ETHIOPIAN));

        $this->assertEquals('ሰኞ፣ ኅዳር 24 ቀን (ተክለ፡ሐይማኖት) 06:08:00 ጡዋት EAT 1988 (ማቴዎስ) ዓ/ም',
            $this->otherDateTime->format(Constants::DATE_ETHIOPIAN_ORTHODOX));

        $this->assertEquals('ማክሰኞ, 21-ኅዳ-1986 00:00:00 EAT',
            $this->dateTime->format(DATE_COOKIE));

        $this->assertEquals('ማክሰኞ፣ ጳጉሜን ፮ ቀን (ኢያሱስ) 23:00:00 እኩለ፡ሌሊት EAT ፲፱፻፺፱ (ዮሐንስ) ዓ/ም',
            $this->yetAnotherDateTime->format(Constants::DATE_GEEZ_ORTHODOX));
    }

    public function test_date_connector()
    {
        foreach (Constants::FORMAT_MAPPER as $format => $function) {
            $this->assertEquals($this->dateTime->{$function}(), $this->dateTime->format($format));
        }
    }

    public function test_processor_trait()
    {
        $this->yetAnotherDateTime->add(new \DateInterval('P1D'));
        $this->assertEquals('ረቡዕ, 01-መስ-2000 23:00:00 EAT',
            $this->yetAnotherDateTime->format(DATE_COOKIE));

        $this->yetAnotherDateTime->sub(new \DateInterval('P3D'));
        $this->assertEquals('እሑ, 04 ጳጉ 1999 23:00:00 +0300',
            $this->yetAnotherDateTime->format(DATE_RFC2822));

        $this->yetAnotherDateTime->modify('+1 hour');
        $this->assertEquals('ሰኞ, 05-ጳጉ-1999 00:00:00 EAT',
            $this->yetAnotherDateTime->format(DATE_COOKIE));

        $this->yetAnotherDateTime->setDate(2005, 5, 5);

        $this->assertEquals('20050505',
            $this->yetAnotherDateTime->format('Ymd'));

        $this->yetAnotherDateTime->setTimestamp(1494567149);
        $this->assertEquals('ዓርብ, 04-ግን-2009 08:32:29 EAT',
            $this->yetAnotherDateTime->format(DATE_COOKIE));

        $this->yetAnotherDateTime->setTime(6, 0, 0);
        $this->assertEquals('ዓርብ 4th of ግንቦት 2009 06:00:00 ጡዋት',
            $this->yetAnotherDateTime->format('l jS \o\f F Y h:i:s A'));

        $this->yetAnotherDateTime->setTimezone(new \DateTimeZone('America/Detroit'));
        $this->assertEquals('ሓሙስ the 3th',
            $this->yetAnotherDateTime->format('l \t\h\e jS'));
    }

    public function test_datetime_diff()
    {
        $diff = $this->dateTime->diff($this->otherDateTime);

        $this->assertDiff($diff);

        $diff = $this->dateTime->diff($this->otherDateTime->toGregorian());

        $this->assertDiff($diff);
    }

    /**
     * @param $diff
     */
    protected function assertDiff($diff)
    {
        $this->assertEquals(2, $diff->y);
        $this->assertEquals(0, $diff->m);
        $this->assertEquals(4, $diff->d);

        $this->assertEquals(6, $diff->h);
        $this->assertEquals(8, $diff->i);
        $this->assertEquals(0, $diff->s);

        $this->assertEquals(734, $diff->days);
    }

    public function test_serialize()
    {
        $serialized = serialize($this->dateTime);

        /** @var DateTime $unserialized */
        $unserialized = unserialize($serialized);

        $diff = $unserialized->diff($this->otherDateTime);

        $this->assertDiff($diff);

        $this->assertEquals('ማክሰኞ፣ ኅዳር 21 ቀን 00:00:00 እኩለ፡ሌሊት EAT 1986 ዓ/ም',
            $this->dateTime->format(Constants::DATE_ETHIOPIAN));
    }

    /**
     * @expectedException \PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage DateTime::modify(): Failed to parse time string (lorem ipsum) at position 0 (l): The timezone could not be found in the database
     */
    public function test_datetime_processor_chaining()
    {
        $this->assertFalse($this->dateTime->modify('lorem ipsum'));
    }

    public function test_gregorian_time()
    {
        $dates = [
            new DateTime(),
            DateTimeFactory::now(),
            DateTimeFactory::fromDateTime(new \DateTime('yesterday')),
            DateTimeFactory::fromTimestamp(1494567149),
            DateTimeFactory::fromConverter(new ToJdnConverter(20, 9, 1983)),
        ];

        foreach ($dates as $date) {
            $ethiopian = $date;
            $gregorian = $ethiopian->toGregorian();

            $this->assertEquals($ethiopian->getHour(), (int) $gregorian->format('H'));
            $this->assertEquals($ethiopian->getMinute(), (int) $gregorian->format('i'));
            $this->assertEquals($ethiopian->getSecond(), (int) $gregorian->format('s'));
            $this->assertEquals($ethiopian->getMicro(), (int) $gregorian->format('u'));
        }
    }
}
