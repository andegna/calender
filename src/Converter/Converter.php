<?php

namespace Andegna\Converter;

use Andegna\Validator\ValidIntegerValidator;

/**
 * Converter abstraction.
 *
 * @see FromJdnConverter
 * @see ToJdnConverter
 */
abstract class Converter
{
    use ValidIntegerValidator;

    /** @var int */
    protected $day;

    /** @var int */
    protected $month;

    /** @var int */
    protected $year;

    /** @var int */
    protected $jdn;

    /**
     * Get the day.
     *
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * Get the month.
     *
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * Get the year.
     *
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Get the JDN.
     *
     * @return int
     */
    public function getJdn(): int
    {
        return $this->jdn;
    }
}
