<?php

namespace Andegna\Validator;

class LeapYearValidator implements Validator
{
    use ValidIntegerValidator;

    private $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function isValid()
    {
        return $this->isValidInteger($this->year) &&
            $this->isValidYear($this->year);
    }

    protected function isValidYear($year)
    {
        return ($year + 1) % 4 == 0;
    }
}
