<?php

namespace Andegna\Holiday;

use Andegna\Converter\FromJdnConverter;
use Andegna\DateTimeFactory;

class Easter
{

    public static function get($year, \DateTimeZone $dateTimeZone = null)
    {
        $julian_year = (int) DateTimeFactory::of($year, 8, 1)
            ->toGregorian()->format('Y');

        $days_after = easter_days($julian_year, CAL_EASTER_ALWAYS_JULIAN);

        $jdn = juliantojd(3, 21, $julian_year);

        $jdn += $days_after;

        $con = new FromJdnConverter($jdn);

        return DateTimeFactory::of($con->getYear(), $con->getMonth(), $con->getDay(),
            0, 0, 0, $dateTimeZone);
    }

}