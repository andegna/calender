<?php

namespace Andegna;

use Andegna\Converter\Converter;
use Andegna\Converter\ToJdnConverter;
use DateTime as GregorianDateTime;
use DateTimeZone;

/**
 * Class DateTimeFactory.
 *
 * A factory to create @see \Andegna\DateTime
 */
class DateTimeFactory
{
    /**
     * Create a @see \Andegna\DateTime representing now.
     *
     * @param DateTimeZone|null $dateTimeZone the timezone
     *
     * @return DateTime the datetime u wanted
     */
    public static function now(DateTimeZone $dateTimeZone = null)
    {
        $dateTimeZone = self::checkForDateTimeZone($dateTimeZone);

        return new DateTime(
            new GregorianDateTime('now', $dateTimeZone)
        );
    }

    /**
     * @param DateTimeZone|null $dateTimeZone the timezone
     *
     * @return DateTimeZone a valid timezone
     */
    protected static function checkForDateTimeZone(DateTimeZone $dateTimeZone = null)
    {
        if (is_null($dateTimeZone)) {
            // get the default timezone from z system
            return new DateTimeZone(date_default_timezone_get());
        }

        return $dateTimeZone;
    }

    /**
     * Create a @see \Andegna\DateTime of year month day ...
     *
     * @param int               $year         ethiopian year
     * @param int               $month        ethiopian month
     * @param int               $day          ethiopian day
     * @param int               $hour         hour
     * @param int               $minute       minute
     * @param int               $second       second
     * @param DateTimeZone|null $dateTimeZone the timezone
     *
     * @return DateTime the datetime u wanted
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

        // Convert to JDN
        $jdn = (new ToJdnConverter($day, $month, $year))->getJdn();

        // The gregorian date in "month/day/year" format
        $gregorian = jdtogregorian($jdn);

        $dateTimeZone = self::checkForDateTimeZone($dateTimeZone);

        $base = new GregorianDateTime(
            "$gregorian $hour:$minute:$second",
            $dateTimeZone
        );

        return new DateTime($base);
    }

    /**
     * @param int               $timestamp    timestamp like @see time()
     * @param DateTimeZone|null $dateTimeZone the timezone
     *
     * @return DateTime the datetime u wanted
     */
    public static function fromTimestamp($timestamp, DateTimeZone $dateTimeZone = null)
    {
        $base = new GregorianDateTime(
            date('Y-m-d H:i:s', $timestamp),
            self::checkForDateTimeZone($dateTimeZone)
        );

        return new DateTime($base);
    }

    /**
     * Just for convenience.
     *
     * @param GregorianDateTime $gregorian
     *
     * @return DateTime the datetime u wanted
     */
    public static function fromDateTime(GregorianDateTime $gregorian)
    {
        return new DateTime($gregorian);
    }

    /**
     * Just for convenience.
     *
     * @param Converter         $con
     * @param DateTimeZone|null $dateTimeZone
     *
     * @return DateTime the datetime u wanted
     */
    public static function fromConverter(Converter $con, DateTimeZone $dateTimeZone = null)
    {
        return static::of(
            $con->getYear(),
            $con->getMonth(),
            $con->getDay(),
            0,
            0,
            0,
            $dateTimeZone
        );
    }
}
