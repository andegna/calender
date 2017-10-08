<?php

namespace Andegna\Converter;

use Andegna\Exception\InvalidDateException;

/**
 * Converts JDN To Ethiopian Date.
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
    public function __construct(int $jdn)
    {
        $this->set($jdn);
    }

    /**
     * Set the JDN for processing.
     *
     * @param $jdn
     *
     * @throws \Andegna\Exception\InvalidDateException
     *
     * @return $this
     */
    public function set(int $jdn)
    {
        if (!$this->isValidInteger($jdn)) {
            throw new InvalidDateException();
        }

        $this->jdn = $jdn;

        $date = static::process($jdn);

        return $this->setDate($date);
    }

    /**
     * @param $jdn integer
     *
     * @return array
     */
    protected static function process(int $jdn): array
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
     * @param $date array
     *
     * @return $this|Converter
     */
    protected function setDate(array $date): Converter
    {
        $this->day = $date['day'];
        $this->month = $date['month'];
        $this->year = $date['year'];

        return $this;
    }
}
