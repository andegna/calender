<?php

namespace Andegna\Converter;

use Andegna\Exception\InvalidDateException;

class FromJdnConverter extends Converter
{
    public function __construct($jdn)
    {
        $this->set($jdn);
    }

    public function set($jdn)
    {
        if (!$this->isValidInteger($jdn)) {
            throw new InvalidDateException();
        }

        $this->jdn = $jdn;

        $date = $this->process($jdn);

        $this->day = $date['day'];
        $this->month = $date['month'];
        $this->year = $date['year'];

        return $this;
    }

    public static function process($jdn)
    {
        $r = (($jdn - 1723856) % 1461);
        $n = ($r % 365) + 365 * (int) ($r / 1460);

        $year = 4 * (int) (($jdn - 1723856) / 1461) +
            (int) ($r / 365) - (int) ($r / 1460);
        $month = (int) ($n / 30) + 1;
        $day = ($n % 30) + 1;

        return compact('day', 'month', 'year');
    }
}
