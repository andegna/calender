<?php

namespace Andegna\Ethiopian;

use Andegna\Converter\Converter;
use Andegna\Converter\FromJdnConverter;
use Andegna\Validator\LeapYearValidator;
use DateTime as BaseDateTime;
use DateTimeZone;

/**
 * Ethiopian DateTime class.
 *
 * @method getYear
 * @method getMonth
 * @method getDay
 * @method getDayOfYear
 * @method getDaysInMonth
 * @method getIsoWeekNumber
 * @method getIsoYearNumber
 * @method isLeapYear
 * @method getHour
 * @method getMinute
 * @method getSecond
 * @method getMicro
 * @method getDayOfWeek
 * @method getTimestamp
 */
class DateTime
{
    use DateTimeProcessor,
        DateFormatter;

    /** @var int */
    protected $year;

    /** @var int */
    protected $month;

    /** @var int */
    protected $day;

    /** @var int */
    protected $dayOfYear;

    /** @var int */
    protected $daysInMonth;

    /** @var int */
    protected $isoWeekNumber;

    /** @var int */
    protected $isoYearNumber;

    /** @var int */
    protected $leapYear;

    /** @var int */
    protected $dateTime;

    /**
     * DateTime constructor.
     *
     * @param BaseDateTime|null $dateTime
     */
    public function __construct(BaseDateTime $dateTime = null)
    {
        if (is_null($dateTime)) {
            $this->dateTime = $this->defaultDateTime();
        } else {
            $this->dateTime = $dateTime;
        }

        $this->updateComputedFields();
    }

    /**
     * @return BaseDateTime
     */
    protected function defaultDateTime()
    {
        $dateTimeZone = new DateTimeZone(date_default_timezone_get());

        // just like the default \DateTime constructor
        return new BaseDateTime('now', $dateTimeZone);
    }

    /**
     * This fields are just for catching.
     *
     * @return void
     */
    protected function updateComputedFields()
    {
        // Julian Date Number of the available datetime
        $jdn = $this->getJdnFromBase($this->dateTime);

        $converter = new FromJdnConverter($jdn);

        $this->setDateFromConverter($converter);
        $this->computeFields();
    }

    /**
     * Return the JDN of the given gregorian date time.
     *
     * @param BaseDateTime $dateTime
     *
     * @return int
     */
    protected function getJdnFromBase(BaseDateTime $dateTime)
    {
        $year = $dateTime->format('Y');
        $month = $dateTime->format('m');
        $day = $dateTime->format('d');

        return gregoriantojd($month, $day, $year);
    }

    /**
     * Set the converted year, month and day from the given converter.
     *
     * @param Converter $converter
     *
     * @return void
     */
    protected function setDateFromConverter(Converter $converter)
    {
        $this->year = $converter->getYear();
        $this->month = $converter->getMonth();
        $this->day = $converter->getDay();
    }

    /**
     * Computer the available properties.
     *
     * @return void
     */
    protected function computeFields()
    {
        $this->computeLeapYear();
        $this->computeDayOfYear();
        $this->computeDaysInMonth();
        $this->computeIsoDateNumber();
    }

    /**
     * Compute the leapYear property.
     *
     * @return void
     */
    protected function computeLeapYear()
    {
        $leapYear = new LeapYearValidator($this->year);

        $this->leapYear = $leapYear->isValid();
    }

    /**
     * Compute the dayOfYear property.
     *
     * @return void
     */
    protected function computeDayOfYear()
    {
        $this->dayOfYear = ($this->month - 1) * 30 + ($this->day - 1);
    }

    /**
     * Compute the daysInMonth property.
     *
     * @return void
     */
    protected function computeDaysInMonth()
    {
        if ($this->month === 13) {
            $this->daysInMonth = $this->leapYear ? 6 : 5;
        }

        $this->daysInMonth = 30;
    }

    /**
     * Compute the isoWeekNumber and isoYearNumber properties.
     *
     * @return void
     */
    protected function computeIsoDateNumber()
    {
        $weekNumber = $this->getISOWeekNumberEstimate();
        $yearNumber = $this->year;

        if ($weekNumber == 0) {
            $yearNumber--;
            $weekNumber = $this->getLastYearLastIsoWeekNumber();
        } elseif ($weekNumber == 53 && $this->doesYearHas53Weeks($this->year)) {
            $yearNumber++;
            $weekNumber = 1;
        }

        $this->isoWeekNumber = $weekNumber;
        $this->isoYearNumber = $yearNumber;
    }

    /**
     * @return int
     */
    protected function getISOWeekNumberEstimate()
    {
        return (int) floor(($this->getDayOfYear() - $this->getDayOfWeek() + 10) / 7);
    }

    /**
     * @return int
     */
    protected function getLastYearLastIsoWeekNumber()
    {
        return DateTimeFactory::lastDayOf($this->year - 1)
            ->getIsoWeekNumber();
    }

    /**
     * @param int $year
     *
     * @return bool
     */
    protected function doesYearHas53Weeks($year)
    {
        $leapYear = (new LeapYearValidator($year))->isValid();
        $lastDayOfTheWeek = DateTimeFactory::lastDayOf($year)->getDayOfWeek();

        return ($lastDayOfTheWeek == 5 && !$leapYear)
            || $lastDayOfTheWeek != 4;
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
