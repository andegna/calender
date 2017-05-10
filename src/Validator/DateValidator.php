<?php

namespace Andegna\Validator;

/**
 * Ethiopian DateValidator
 *
 * @package Andegna\Validator
 */
class DateValidator implements Validator
{
    use ValidIntegerValidator;

    const FIRST_DAY = 1;

    const FIRST_MONTH = self::FIRST_DAY;

    const LAST_DAY = 30;

    const LAST_MONTH = 13;

    const PAGUME_LAST_DAY = 5;

    const PAGUME_LEAP_YEAR_LAST_DAY = 6;

    /** @var int */
    protected $day;

    /** @var int */
    protected $month;

    /** @var int */
    protected $year;

    /**
     * DateValidator constructor.
     *
     * @param $day int
     * @param $month int
     * @param $year int
     */
    public function __construct($day, $month, $year)
    {
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * validate the ethiopian date
     *
     * @return bool true if valid
     */
    public function isValid()
    {
        return
            $this->isValidInteger($this->day, $this->month, $this->year) &&

            $this->isValidDayRange($this->day) &&

            $this->isValidMonthRange($this->month) &&

            $this->isValidPagumeDayRange($this->day, $this->month) &&

            $this->isValidLeapDay($this->day, $this->month, $this->year);
    }

    /**
     * @param $day int
     *
     * @return bool
     */
    protected function isValidDayRange($day)
    {
        return $day >= self::FIRST_DAY &&
            $day <= self::LAST_DAY;
    }

    /**
     * @param $month int
     *
     * @return bool
     */
    protected function isValidMonthRange($month)
    {
        return $month >= self::FIRST_MONTH &&
            $month <= self::LAST_MONTH;
    }

    /**
     * @param $day int
     * @param $month int
     *
     * @return bool
     */
    protected function isValidPagumeDayRange($day, $month)
    {
        if ($month === self::LAST_MONTH) {
            return $day <= self::PAGUME_LEAP_YEAR_LAST_DAY;
        }

        return true;
    }

    /**
     * @param $day
     * @param $month
     * @param $year
     *
     * @return bool
     */
    protected function isValidLeapDay($day, $month, $year)
    {
        if ($month === self::LAST_MONTH 
            && $day === self::PAGUME_LEAP_YEAR_LAST_DAY
        ) {
            return (new LeapYearValidator($year))->isValid();
        }

        return true;
    }
}
