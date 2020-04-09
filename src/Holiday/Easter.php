<?php

namespace Andegna\Holiday;

use Andegna\Converter\FromJdnConverter;
use Andegna\DateTimeFactory;
use DateTimeZone;

/**
 * Ethiopian Easter.
 */
class Easter implements HolidayInterface
{
    /** @var DateTimeZone */
    private $dateTimeZone;

    /**
     * Easter constructor.
     *
     * @param DateTimeZone $dateTimeZone
     */
    public function __construct(DateTimeZone $dateTimeZone = null)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $year)
    {
        // convert the Ethiopian year to a Julian year
        // ሚያዝያ 1 is just a random day after the Gregorian new year
        $julian_year = (int) DateTimeFactory::of($year, 8, 1)
            ->toGregorian()->format('Y');

        // get the number of days from vernal equinox to the Easter in the given Julian year
        $days_after = easter_days($julian_year, CAL_EASTER_ALWAYS_JULIAN);

        // get the JDN of vernal equinox (March 21) in the given Julian year
        $jdn = juliantojd(3, 21, $julian_year);

        // add the number of days to Easter
        $jdn += $days_after;

        // create a Ethiopian Date to JDN converter
        $con = new FromJdnConverter($jdn);

        // create an Ethiopian date from the converter
        return DateTimeFactory::of(
            $con->getYear(),
            $con->getMonth(),
            $con->getDay(),
            0,
            0,
            0,
            $this->dateTimeZone
        );
    }
}
