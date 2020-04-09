<?php

namespace Andegna\Holiday;

/**
 * Ethiopian Holiday.
 */
interface Holiday
{
    /**
     * Get the holiday `Andegna\DateTime` of a given Ethiopian year.
     *
     * @param $year int Ethiopian year
     *
     * @return \Andegna\DateTime
     */
    public function get(int $year);
}
