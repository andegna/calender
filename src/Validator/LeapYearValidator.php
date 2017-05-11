<?php

namespace Andegna\Validator;

/**
 * Ethiopian Leap Year Validator.
 */
class LeapYearValidator implements ValidatorInterface
{
    use ValidIntegerValidator;

    /** @var int */
    protected $year;

    /**
     * Leap Year Validator constructor.
     *
     * @param $year int the year
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    /**
     * @return bool true if valid
     */
    public function isValid()
    {
        return
            $this->isValidInteger($this->year) &&
            $this->isValidLeapYear($this->year);
    }

    /**
     * @param $year int
     *
     * @return bool true if valid
     */
    protected function isValidLeapYear($year)
    {
        return ($year + 1) % 4 === 0;
    }
}
