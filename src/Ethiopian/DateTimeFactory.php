<?php

namespace Andegna\Ethiopian;

use Andegna\Converter\ToJdnConverter;
use Andegna\Validator\LeapYearValidator;
use DateTime as BaseDateTime;
use DateTimeZone;

class DateTimeFactory
{
    /**
     * Create a date time representing now.
     *
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return DateTime
     */
    public static function now(DateTimeZone $dateTimeZone = null)
    {
        $dateTimeZone = self::defaultDateTimeZone($dateTimeZone);

        return new DateTime(
            new BaseDateTime('now', $dateTimeZone)
        );
    }

    /**
     * @param $dateTimeZone
     *
     * @return DateTimeZone
     */
    protected static function defaultDateTimeZone($dateTimeZone)
    {
        if (is_null($dateTimeZone)) {
            return new DateTimeZone(date_default_timezone_get());
        }

        return $dateTimeZone;
    }

    /**
     * Get the last day of year and month.
     *
     * @param $year
     * @param int $month
     *
     * @return DateTime
     */
    public static function lastDayOf($year, $month = 13)
    {
        $leapYear = (new LeapYearValidator($year))->isValid();
        $lastDay = 30;

        if ($month == 13) {
            $lastDay = $leapYear ? 6 : 5;
        }

        return static::of($year, $month, $lastDay);
    }

    /**
     * Create a DateTime of year month day ...
     *
     * @param int               $year
     * @param int               $month
     * @param int               $day
     * @param int               $hour
     * @param int               $minute
     * @param int               $second
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return DateTime
     */
    public static function of(
        $year,
        $month,
        $day,
        $hour = 0,
        $minute = 0,
        $second = 0,
        DateTimeZone $dateTimeZone = null
    ) {

        // Convert to Julian Date Number
        $jdn = (new ToJdnConverter($day, $month, $year))->getJdn();

        // The gregorian date in "month/day/year" format
        $gregorian = \jdtogregorian($jdn);

        $dateTimeZone = self::defaultDateTimeZone($dateTimeZone);

        $base = new BaseDateTime("$gregorian $hour:$minute:$second", $dateTimeZone);

        return new DateTime($base);
    }
}
