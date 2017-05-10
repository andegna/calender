<?php

namespace Andegna\Holiday;

use Andegna\Converter\FromJdnConverter;
use Andegna\DateTimeFactory;
use DateTimeZone;

/**
 * Ethiopian Easter
 *
 * @package Andegna\Holiday
 */
class Easter
{
    /** @var DateTimeZone */
    private $dateTimeZone;


    /**
     * Easter constructor.
     * @param DateTimeZone $dateTimeZone
     */
    public function __construct(DateTimeZone $dateTimeZone)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    /**
     * Get the easter date of a given Ethiopian year
     *
     * @param $year int Ethiopian year
     *
     * @return \Andegna\DateTime
     */
    public function get($year)
    {
        $julian_year = (int)DateTimeFactory::of($year, 8, 1)
            ->toGregorian()->format('Y');

        $days_after = easter_days($julian_year, CAL_EASTER_ALWAYS_JULIAN);

        $jdn = juliantojd(3, 21, $julian_year);

        $jdn += $days_after;

        $con = new FromJdnConverter($jdn);

        return DateTimeFactory::of($con->getYear(), $con->getMonth(), $con->getDay(),
            0, 0, 0, $this->dateTimeZone);
    }

}
