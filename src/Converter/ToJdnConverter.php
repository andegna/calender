<?php

namespace Andegna\Converter;

use Andegna\Exception\InvalidDateException;
use Andegna\Validator\DateValidator as DateValidator;

/**
 * ToJdnConverter.
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
    public function __construct($day, $month, $year)
    {
        $this->set($day, $month, $year);
    }

    /**
     * @param $day
     * @param $month
     * @param $year
     *
     * @throws \Andegna\Exception\InvalidDateException
     *
     * @return $this
     */
    public function set($day, $month, $year)
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
