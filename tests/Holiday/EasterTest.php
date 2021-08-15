<?php
/**
 * Created by PhpStorm.
 * User: stark
 * Date: 5/12/17
 * Time: 7:42 AM.
 */

namespace Andegna\PHPUnit\Holiday;

use Andegna\DateTime;
use Andegna\Holiday\Easter;
use PHPUnit\Framework\TestCase;

class EasterTest extends TestCase
{
    /** @var Easter */
    protected $easter;

    protected function setUp(): void
    {
        parent::setUp();

        date_default_timezone_set('Africa/Addis_Ababa');

        $this->easter = new Easter(new \DateTimeZone('Africa/Addis_Ababa'));
    }

    /**
     * Eastern Orthodox churches easter dates.
     *
     * @link https://en.wikipedia.org/wiki/Computus
     *
     * @return array
     */
    public function easterDatesDataProvider()
    {
        return [
            [1997, 'April 27'],
            [1998, 'April 19'],
            [1999, 'April 11'],
            [2000, 'April 30'],
            [2001, 'April 15'],
            [2002, 'May 5'],
            [2003, 'April 27'],
            [2004, 'April 11'],
            [2005, 'May 1'],
            [2006, 'April 23'],
            [2007, 'April 8'],
            [2008, 'April 27'],
            [2009, 'April 19'],
            [2010, 'April 4'],
            [2011, 'April 24'],
            [2012, 'April 15'],
            [2013, 'May 5'],
            [2014, 'April 20'],
            [2015, 'April 12'],
            [2016, 'May 1'],
            [2017, 'April 16'],
            [2018, 'April 8'],
            [2019, 'April 28'],
            [2020, 'April 19'],
            [2021, 'May 2'],
            [2022, 'April 24'],
            [2023, 'April 16'],
            [2024, 'May 5'],
            [2025, 'April 20'],
            [2026, 'April 12'],
            [2027, 'May 2'],
            [2028, 'April 16'],
            [2029, 'April 8'],
            [2030, 'April 28'],
            [2031, 'April 13'],
            [2032, 'May 2'],
            [2033, 'April 24'],
            [2034, 'April 9'],
            [2035, 'April 29'],
            [2036, 'April 20'],
            [2037, 'April 5'],
        ];
    }

    /**
     * @dataProvider easterDatesDataProvider
     *
     * @param $year
     * @param $day_month
     */
    public function test_easter_date($year, $day_month)
    {
        $gregorian = \DateTime::createFromFormat('F j Y', "$day_month $year");

        $expected = new DateTime($gregorian);

        $ethiopian = $this->easter->get($expected->getYear());

        $this->assertEquals($expected->getYear(), $ethiopian->getYear());
        $this->assertEquals($expected->getMonth(), $ethiopian->getMonth());
        $this->assertEquals($expected->getDay(), $ethiopian->getDay());
    }
}
