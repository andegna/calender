<?php

namespace Andegna\Operations;

use Andegna\Converter\ToJdnConverter;
use Andegna\DateTime;
use DateInterval;
use DateTimeZone;

/**
 * Processor trait <br />
 * works on dateTime property.
 */
trait Processor
{
    /**
     * @param mixed $dateTime
     *
     * @return mixed
     */
    protected function fixForChaining($dateTime = false)
    {
        if ($dateTime === false) {
            return $dateTime;
        }

        $this->updateComputedFields();

        return $this;
    }

    /**
     * Adds an amount of days, months, years, hours, minutes and seconds to a DateTime object.
     *
     * @param DateInterval $interval
     *
     * @return DateTime|bool
     */
    public function add(DateInterval $interval)
    {
        return $this->fixForChaining($this->dateTime->add($interval));
    }

    /**
     * Subtracts an amount of days, months, years, hours, minutes and seconds from a DateTime object.
     *
     * @param DateInterval $interval
     *
     * @return DateTime|bool
     */
    public function sub(DateInterval $interval)
    {
        return$this->fixForChaining($this->dateTime->sub($interval));
    }

    /**
     * Alters the timestamp.
     *
     * @param  $modify
     *
     * @return DateTime|bool
     */
    public function modify($modify)
    {
        return $this->fixForChaining($this->dateTime->modify($modify));
    }

    /**
     * Returns the difference between two DateTime objects.
     *
     * @param  $datetime
     * @param bool $absolute
     *
     * @return DateInterval
     */
    public function diff($datetime, $absolute = false)
    {
        if ($datetime instanceof DateTime) {
            return $this->dateTime->diff($datetime->toGregorian(), $absolute);
        }

        return $this->dateTime->diff($datetime, $absolute);
    }

    /**
     * Sets the date.
     *
     * @param $year
     * @param $month
     * @param $day
     *
     * @return DateTime
     */
    public function setDate($year, $month, $day)
    {
        $jdn = (new ToJdnConverter($day, $month, $year))->getJdn();

        $gregorian = jdtogregorian($jdn);

        list($month, $day, $year) = explode('/', $gregorian);

        $this->fixForChaining($this->dateTime->setDate((int) $year, (int) $month, (int) $day));
    }

    /**
     * Sets the time.
     *
     * @param $hour
     * @param $minute
     * @param int $second
     *
     * @return DateTime
     */
    public function setTime($hour, $minute, $second = 0)
    {
        return $this->fixForChaining($this->dateTime->setTime($hour, $minute, $second));
    }

    /**
     * Sets the date and time based on an Unix timestamp.
     *
     * @param $unixtimestamp
     *
     * @return DateTime
     */
    public function setTimestamp($unixtimestamp)
    {
        return $this->fixForChaining($this->dateTime->setTimestamp($unixtimestamp));
    }

    /**
     * Sets the time zone for the DateTime object.
     *
     * @param $timezone
     *
     * @return DateTime
     */
    public function setTimezone($timezone)
    {
        return $this->fixForChaining($this->dateTime->setTimezone($timezone));
    }

    /**
     * Returns the timezone offset.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->dateTime->getOffset();
    }

    /**
     * Return time zone relative to given DateTime.
     *
     * @return DateTimeZone
     */
    public function getTimezone()
    {
        return $this->dateTime->getTimezone();
    }

    /**
     * The __wakeup handler.
     */
    public function __wakeup()
    {
        return $this->dateTime->__wakeup();
    }
}
