<?php

namespace Andegna;

use DateTime as BaseDateTime;

/**
 * Ethiopian DateTime class.
 */
class DateTime
{
    use Operations\Initiator,
        Operations\Processor,
        Operations\Formatter;

    /**
     * The Gregorian Date
     *
     * @var BaseDateTime
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
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return bool
     */
    public function isLeapYear()
    {
        return $this->leapYear;
    }

    /**
     * @return int
     */
    public function getDayOfYear()
    {
        return $this->dayOfYear;
    }

    /**
     * @return int
     */
    public function getDaysInMonth()
    {
        return $this->daysInMonth;
    }

    /**
     * @return int
     */
    public function getHour()
    {
        return intval($this->dateTime->format('G'));
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return intval($this->dateTime->format('i'));
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return intval($this->dateTime->format('s'));
    }

    /**
     * @return int
     */
    public function getMicro()
    {
        return intval($this->dateTime->format('u'));
    }


    /**
     * @return int
     */
    public function getDayOfWeek()
    {
        return intval($this->dateTime->format('N'));
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return intval($this->dateTime->format('U'));
    }

    /**
     * DateTime constructor.
     *
     * @param BaseDateTime|null $dateTime
     */
    public function __construct(BaseDateTime $dateTime = null)
    {
        if (null === $dateTime) {
            $this->dateTime = new BaseDateTime('now');
        } else {
            $this->dateTime = $dateTime;
        }

        $this->updateComputedFields();
    }

    /**
     * Return the <b>clone</b> of the base gregorian date time.
     *
     * @return BaseDateTime
     */
    public function toGregorian()
    {
        return clone $this->dateTime;
    }

}
