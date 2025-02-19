<?php
namespace Andegna\AgeCalculator;

use Andegna\DateTimeFactory;
use Andegna\Exception\InvalidDateException;
use Andegna\Validator\DateValidator;
use DateTime;

/**
 * Calculates the age based on an Ethiopian date.
 */
class AgeCalculator
{
    private $ethiopianYear;
    private $ethiopianMonth;
    private $ethiopianDay;

    /**
     * AgeCalculator constructor.
     *
     * @param int $ethiopianYear
     * @param int $ethiopianMonth
     * @param int $ethiopianDay
     *
     * @throws \Andegna\Exception\InvalidDateException
     */
    public function __construct(int $ethiopianYear, int $ethiopianMonth, int $ethiopianDay)
    {
        $this->set($ethiopianYear, $ethiopianMonth, $ethiopianDay);
    }

    /**
     * Set the Ethiopian date for processing.
     *
     * @param int $ethiopianYear
     * @param int $ethiopianMonth
     * @param int $ethiopianDay
     *
     * @throws \Andegna\Exception\InvalidDateException
     *
     * @return $this
     */
    public function set(int $ethiopianYear, int $ethiopianMonth, int $ethiopianDay): self
    {
        $validator = new DateValidator($ethiopianDay, $ethiopianMonth, $ethiopianYear);
        if (!$validator->isValid()) {
            throw new InvalidDateException();
        }

        $this->ethiopianYear = $ethiopianYear;
        $this->ethiopianMonth = $ethiopianMonth;
        $this->ethiopianDay = $ethiopianDay;

        return $this;
    }

    /**
     * Calculate the age based on the Ethiopian date.
     *
     * @throws \Andegna\Exception\InvalidDateException
     * 
     * @return int
     
     */
    public function calculateAge(): int
    {
        try {
            $ethiopianDateTime = DateTimeFactory::of($this->ethiopianYear, $this->ethiopianMonth, $this->ethiopianDay);
        } catch (\Exception $e) {
            throw new InvalidDateException();
        }

        $gregorianDate = $ethiopianDateTime->toGregorian();
        // Set time to midnight to ignore time component
        $gregorianDate->setTime(0, 0, 0);

        $currentDate = new DateTime('today'); // Current date at midnight

        if ($currentDate < $gregorianDate) {
            throw new InvalidDateException('The provided date is in the future.');
        }

        $ageInterval = $currentDate->diff($gregorianDate);
        
        return $ageInterval->y;
    }
    
}
