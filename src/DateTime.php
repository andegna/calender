<?php

namespace Andegna;

use DateTime as GregorianDateTime;

/**
 * Ethiopian Andegna DateTime class.
 */
class DateTime
{
    use Operations\Initiator;
    use Operations\Processor;
    use Operations\Formatter;

    /**
     * The Gregorian Date.
     *
     * @var GregorianDateTime
     */
    protected $dateTime;

    /** @var int */
    protected $year;

    /** @var int */
    protected $month;

    /** @var int */
    protected $day;

    /** @var bool */
    protected $leapYear;

    /** @var int */
    protected $dayOfYear;

    /** @var int */
    protected $daysInMonth;

    /**
     * Returns the Ethiopian Year.
     *
     * @return int year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Returns the Ethiopian Month.
     *
     * @return int month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Returns the Ethiopian Day.
     *
     * @return int day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Returns true if the Year is a leap.
     *
     * @return bool leap year
     */
    public function isLeapYear()
    {
        return $this->leapYear;
    }

    /**
     * Returns the day Of the Year.
     *
     * Day of the year is the number of days(inclusive)
     * have passed since the new year
     *
     * Eg. 'ኅዳር 29' day of the year is 89
     *
     * @return int day Of the Year
     */
    public function getDayOfYear()
    {
        return $this->dayOfYear;
    }

    /**
     * Returns number of days in the given year.
     *
     * It's 30 except 'ጳጉሜን'
     *
     * @return int days in the month
     */
    public function getDaysInMonth()
    {
        return $this->daysInMonth;
    }

    /**
     * Returns the Hour.
     *
     * @return int hour
     */
    public function getHour()
    {
        return (int) $this->dateTime->format('G');
    }

    /**
     * Returns the Minute.
     *
     * @return int minute
     */
    public function getMinute()
    {
        return (int) $this->dateTime->format('i');
    }

    /**
     * Returns the Second.
     *
     * @return int second
     */
    public function getSecond()
    {
        return (int) $this->dateTime->format('s');
    }

    /**
     * Returns the Micro.
     *
     * @return int micro
     */
    public function getMicro()
    {
        return (int) $this->dateTime->format('u');
    }

    /**
     * Returns the Day of the week.
     *
     * 1 (for ሰኞ) through 7 (for እሑድ)
     *
     * @return int day of the week
     */
    public function getDayOfWeek()
    {
        return (int) $this->dateTime->format('N');
    }

    /**
     * Returns the Timestamp.
     *
     * @see    time()
     *
     * @return int timestamp
     */
    public function getTimestamp()
    {
        return (int) $this->dateTime->format('U');
    }

    /**
     * DateTime constructor.
     *
     * @param GregorianDateTime|null $dateTime
     */
    public function __construct(GregorianDateTime $dateTime = null)
    {
        if (null === $dateTime) {
            $this->dateTime = new GregorianDateTime('now');
        } else {
            $this->dateTime = $dateTime;
        }

        $this->updateComputedFields();
    }

    /**
     * Return the <b>clone</b> of the base gregorian datetime.
     *
     * @return GregorianDateTime
     */
    public function toGregorian()
    {
        return clone $this->dateTime;
    }
}
