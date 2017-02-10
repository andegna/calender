<?php

namespace Andegna\Converter;

use Andegna\Exception\InvalidDateException;

/**
 * FromJdnConverter.
 */
class FromJdnConverter extends Converter
{
    /**
     * FromJdnConverter constructor.
     *
     * @param $jdn int
     *
     * @throws \Andegna\Exception\InvalidDateException
     */
    public function __construct($jdn)
    {
        $this->set($jdn);
    }

    /**
     * @param $jdn
     *
     * @throws \Andegna\Exception\InvalidDateException
     *
     * @return $this
     */
    public function set($jdn)
    {
        if (!$this->isValidInteger($jdn)) {
            throw new InvalidDateException();
        }

        $this->jdn = $jdn;

        $date = static::process($jdn);

        return $this->setDate($date);
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

    /**
     * @param $date
     *
     * @return $this
     */
    protected function setDate($date)
    {
        $this->day = $date['day'];
        $this->month = $date['month'];
        $this->year = $date['year'];

        return $this;
    }
}
