<?php

namespace Andegna;

/**
 * Class Calender <br />
 * A set of functions to convert ethiopian date to JDN and vise versa.

 * @package Andegna
 */
class Calender
{

    /**
     * Return a true if the year is a leap year based on the ethiopian calendar.
     *
     * @param int $year the ethiopian date to be checked
     *
     * @return boolean
     */
    public static function isEthiopianLeapYear($year)
    {
        if (!is_int($year)) {
            trigger_error(
                'isEthiopianLeapYear() expects parameter 1 to be numeric. ' .
                gettype($year) . ' given',
                E_USER_WARNING
            );
        }
        return ($year + 1) % 4 == 0;
    }

    /**
     * Returns true if the <code>$month, $day and $year</code> passed
     * are a valid date based on the ethiopian calendar.
     *
     * @param int $month Ethiopian month
     * @param int $day   Ethiopian day
     * @param int $year  Ethiopian year (negative for AD)
     *
     * @return bool
     */
    public static function ethiopianCheckDate($month, $day, $year)
    {
        return
            // validate all
            is_int($month) && is_int($day) && is_int($year) &&
            // true if the day is btn 1 - 30
            ($day <= 30 && $day >= 1) &&
            // true if the month is btn 1 - 13
            ($month <= 13 && $month >= 1) &&
            // true if the month is 13 then day is btn 1 - 6
            ($month == 13 ? $day <= 6 : true) &&
            // true if the month is 13 & day is 6 then year must be leap year
            ($month == 13 && $day == 6 ?
                self::isEthiopianLeapYear($year) : true);
    }

    /**
     * Returns the julian date number representation of the
     * given ethiopian date.
     *
     * @param int $month Ethiopian month
     * @param int $day   Ethiopian day
     * @param int $year  Ethiopian year (negative for AD)
     *
     * @return int
     */
    public static function ethiopianToJd($month = 1, $day = 1, $year = 2000)
    {
        if (!self::ethiopianCheckDate($month, $day, $year)) {
            trigger_error(
                'ethiopianToJd() expects the date to be valid.' .
                ' check ethiopianCheckDate() first',
                E_USER_WARNING
            );
        }
        return (1723856 + 365) +
        365 * ($year - 1) +
        (int)($year / 4) +
        30 * $month +
        $day - 31;
    }

    /**
     * Returns the ethiopian date string which is represented by
     * the passed jdn <br />
     *
     * @param  int  $jdn   the Julian Date Number
     * @param  bool $array if this is true the function returns
     *         the day,month and year in associative array.
     * @return array|string
     */
    public static function jdToEthiopian($jdn, $array = false)
    {
        if (!is_int($jdn)) {
            trigger_error(
                'jdToEthiopian() expects parameter 1 to be numeric. ' .
                gettype($jdn) . ' given',
                E_USER_WARNING
            );
            return self::jdToEthiopian(self::ethiopianToJd());
        }
        $r = (($jdn - 1723856) % 1461);
        $n = ($r % 365) + 365 * (int)($r / 1460);
        $year = 4 * (int)(($jdn - 1723856) / 1461) +
            (int)($r / 365) - (int)($r / 1460);
        $month = (int)($n / 30) + 1;
        $day = ($n % 30) + 1;

        return ($array ? compact('day', 'month', 'year') : "$month/$day/$year");
    }
}
