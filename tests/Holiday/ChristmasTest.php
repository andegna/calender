<?php

namespace Andegna\PHPUnit\Holiday;

use Andegna\Holiday\Christmas;
use PHPUnit\Framework\TestCase;

class ChristmasTest extends TestCase
{
    /** @var Christmas */
    protected $christmas;

    protected function setUp(): void
    {
        parent::setUp();

        date_default_timezone_set('Africa/Addis_Ababa');

        $this->christmas = new Christmas(new \DateTimeZone('Africa/Addis_Ababa'));
    }

    /**
     * Eastern Orthodox churches christmas dates.
     *
     * @return array
     */
    public function christmasDatesDataProvider()
    {
        return [
            [2010, 29],
            [2011, 29],
            [2012, 28],
            [2013, 29],
            [2014, 29],
            [2015, 29],
            [2016, 28],
            [2017, 29],
        ];
    }

    /**
     * @dataProvider christmasDatesDataProvider
     *
     * @param $year
     * @param $day
     */
    public function test_christmas_date($year, $day)
    {
        $ethiopian = $this->christmas->get($year);

        $this->assertEquals($year, $ethiopian->getYear());
        $this->assertEquals(4, $ethiopian->getMonth());
        $this->assertEquals($day, $ethiopian->getDay());
    }
}
