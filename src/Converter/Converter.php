<?php

namespace Andegna\Converter;

use Andegna\Validator\ValidIntegerValidator;

abstract class Converter
{
    use ValidIntegerValidator;

    protected $day;
    protected $month;
    protected $year;

    protected $jdn;

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getJdn()
    {
        return $this->jdn;
    }
}
