<?php

namespace Andegna\Operations;

use Andegna\Converter\Converter;
use Andegna\Converter\FromJdnConverter;
use Andegna\Validator\LeapYearValidator;
use DateTime as GregorianDateTime;

/**
 * Initiator trait.
 */
trait Initiator
{
    /**
     * This fields are just for catching.
     *
     * @return void
     */
    protected function updateComputedFields()
    {
        // Julian Date Number of the available datetime
        $jdn = $this->getJdnFromBase($this->dateTime);

        $converter = new FromJdnConverter($jdn);

        $this->setDateFromConverter($converter);
        $this->cacheTimestamp();
        $this->computeFields();
    }

    /**
     * Return the JDN of the given gregorian date time.
     *
     * @param GregorianDateTime $dateTime
     *
     * @return int
     */
    protected function getJdnFromBase(GregorianDateTime $dateTime): int
    {
        $year = $dateTime->format('Y');
        $month = $dateTime->format('m');
        $day = $dateTime->format('d');

        return gregoriantojd($month, $day, $year);
    }

    /**
     * Set the converted year, month and day from the given converter.
     *
     * @param Converter $converter
     *
     * @return void
     */
    protected function setDateFromConverter(Converter $converter)
    {
        $this->year = $converter->getYear();
        $this->month = $converter->getMonth();
        $this->day = $converter->getDay();
    }

    /**
     * Set the timestamp field.
     */
    protected function cacheTimestamp()
    {
        $this->timestamp = $this->dateTime->getTimestamp();
    }

    /**
     * Computer the available properties.
     *
     * @return void
     */
    protected function computeFields()
    {
        $this->computeLeapYear();
        $this->computeDayOfYear();
        $this->computeDaysInMonth();
        $this->cacheDayOfWeek();
    }

    /**
     * Compute the leapYear property.
     *
     * @return void
     */
    protected function computeLeapYear()
    {
        $leapYear = new LeapYearValidator($this->year);

        $this->leapYear = $leapYear->isValid();
    }

    /**
     * Compute the dayOfYear property.
     *
     * @return void
     */
    protected function computeDayOfYear()
    {
        $this->dayOfYear = ($this->month - 1) * 30 + $this->day;
    }

    /**
     * Compute the daysInMonth property.
     *
     * @return void
     */
    protected function computeDaysInMonth()
    {
        $this->daysInMonth = $this->month === 13 ? ($this->leapYear ? 6 : 5) : 30;
    }

    /**
     * cache the dayOfWeek property.
     *
     * @return void
     */
    protected function cacheDayOfWeek()
    {
        $this->dayOfWeek = (int) $this->dateTime->format('N');
    }
}
