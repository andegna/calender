<?php

namespace Andegna\Validator;

/**
 * Ethiopian DateValidator.
 */
class DateValidator implements ValidatorInterface
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
     * validate the ethiopian date.
     *
     * @return bool true if valid
     */
    public function isValid()
    {
        $validators = [
            'isDateValuesIntegers',
            'isValidDayRange',
            'isValidMonthRange',
            'isValidPagumeDayRange',
            'isValidLeapDay',
        ];

        return array_reduce($validators, function ($result, $validator) {
            return $result && $this->{$validator}();
        }, true);
    }

    /**
     * @return bool
     */
    protected function isValidDayRange()
    {
        return $this->day >= self::FIRST_DAY &&
            $this->day <= self::LAST_DAY;
    }

    /**
     * @return bool
     */
    protected function isValidMonthRange()
    {
        return $this->month >= self::FIRST_MONTH &&
            $this->month <= self::LAST_MONTH;
    }

    /**
     * @return bool
     */
    protected function isValidPagumeDayRange()
    {
        if ($this->month === self::LAST_MONTH) {
            return $this->day <= self::PAGUME_LEAP_YEAR_LAST_DAY;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function isValidLeapDay()
    {
        if ($this->month === self::LAST_MONTH &&
            $this->day === self::PAGUME_LEAP_YEAR_LAST_DAY
        ) {
            return (new LeapYearValidator($this->year))->isValid();
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function isDateValuesIntegers()
    {
        return $this->isValidInteger($this->day, $this->month, $this->year);
    }
}
