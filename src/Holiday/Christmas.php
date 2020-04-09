<?php

namespace Andegna\Holiday;

use Andegna\DateTimeFactory;
use Andegna\Validator\LeapYearValidator;
use DateTimeZone;

/**
 * Ethiopian Christmas.
 */
class Christmas implements HolidayInterface
{
    const TAHISAS = 4; // ታህሳስ ወር

    /** @var DateTimeZone */
    private $dateTimeZone;

    /**
     * Christmas constructor.
     *
     * @param DateTimeZone $dateTimeZone
     */
    public function __construct(DateTimeZone $dateTimeZone = null)
    {
        $this->dateTimeZone = $dateTimeZone;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $year)
    {
        $day = 29;

        if ($this->wasAfterALeapYear($year)) {
            $day = 28;
        }

        return DateTimeFactory::of($year, self::TAHISAS, $day, 0, 0, 0, $this->dateTimeZone);
    }

    private function wasAfterALeapYear(int $year): bool
    {
        $previous = $year - 1;

        return (new LeapYearValidator($previous))->isValid();
    }
}
