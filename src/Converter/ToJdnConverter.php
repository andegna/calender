<?php

namespace Andegna\Converter;

use Andegna\Exception\InvalidDateException;
use Andegna\Validator\DateValidator as DateValidator;

/**
 * Converts Ethiopian Date to JDN.
 */
class ToJdnConverter extends Converter
{
    /**
     * ToJdnConverter constructor.
     *
     * @param $day
     * @param $month
     * @param $year
     *
     * @throws \Andegna\Exception\InvalidDateException
     */
    public function __construct(int $day, int $month, int $year)
    {
        $this->set($day, $month, $year);
    }

    /**
     * Set the date for processing.
     *
     * @param $day
     * @param $month
     * @param $year
     *
     * @throws \Andegna\Exception\InvalidDateException
     *
     * @return $this
     */
    public function set(int $day, int $month, int $year)
    {
        $validator = new DateValidator($day, $month, $year);

        if (!$validator->isValid()) {
            throw new InvalidDateException();
        }

        $this->day = $day;
        $this->month = $month;
        $this->year = $year;

        $this->jdn = (int) static::process($day, $month, $year);

        return $this;
    }

    /**
     * @param $day
     * @param $month
     * @param $year
     *
     * @return int
     */
    protected static function process($day, $month, $year)
    {
        return
            (1723856 + 365) +
            365 * ($year - 1) +
            (int) ($year / 4) +
            30 * $month +
            $day - 31;
    }
}
