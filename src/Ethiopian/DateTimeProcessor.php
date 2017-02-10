<?php

namespace Andegna\Ethiopian;

use Andegna\Converter\ToJdnConverter;

/**
 * DateTimeProcessor trait <br />
 * works on dateTime property
 *
 * @package Andegna\Ethiopian
 */
trait DateTimeProcessor
{
    public function add($interval)
    {
        return new DateTime($this->dateTime->add($interval));
    }

    public function sub($interval)
    {
        return new DateTime($this->dateTime->sub($interval));
    }

    public function modify($modify)
    {
        return new DateTime($this->dateTime->modify($modify));
    }

    public function diff($datetime, $absolute = false)
    {
        return $this->dateTime->diff($datetime, $absolute);
    }

    public function setDate($year, $month, $day)
    {
        $jdn = (new ToJdnConverter($day, $month, $year))->getJdn();

        $gregorian = jdtogregorian($jdn);

        list(
            $month,
            $day,
            $year) = explode('/', $gregorian);

        return new DateTime(
            $this->dateTime->setDate((int) $year, (int) $month, (int) $day)
        );
    }

    public function setTime($hour, $minute, $second = 0)
    {
        return new DateTime(
            $this->dateTime->setTime($hour, $minute, $second)
        );
    }

    public function setTimestamp($unixtimestamp)
    {
        return new DateTime(
            $this->dateTime->setTimestamp($unixtimestamp)
        );
    }

    public function setTimezone($timezone)
    {
        return new DateTime(
            $this->dateTime->setTimezone($timezone)
        );
    }

    public function getOffset()
    {
        return $this->dateTime->getOffset();
    }

    public function getTimezone()
    {
        return $this->dateTime->getTimezone();
    }

    public function __wakeup()
    {
        return $this->dateTime->__wakeup();
    }
}
