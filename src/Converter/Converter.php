<?php

namespace Andegna\Converter;

use Andegna\Validator\ValidIntegerValidator;

/**
 * Converter abstraction.
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
     * @return int
     */
    public function getDay()
    {
        return $this->day;
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
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getJdn()
    {
        return $this->jdn;
    }
}
