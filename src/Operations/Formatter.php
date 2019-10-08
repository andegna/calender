<?php

namespace Andegna\Operations;

use Andegna\Constants;
use Geezify\Geezify;

/**
 * class DateFormatter.
 *
 * This class deals with the date time formatting issue
 */
trait Formatter
{
    /**
     * Accepts the same format as the date() function.
     *
     * @see date(), \DateTime
     *
     * @param $format
     *
     * @return string
     */
    public function format(string $format)
    {
        $result = '';
        $length = \mb_strlen($format);

        $skip_next = false;

        // iterate for each character
        for ($index = 0; $index < $length; $index++) {
            $format_char = mb_substr($format, $index, 1);

            $result .= $this->getValueOfFormatCharacter($format_char, $skip_next);
        }

        // remove null bits if they exist
        return str_replace("\0", '', $result);
    }

    /**
     * Return the value of the format character.
     *
     * @param string $name of the field
     * @param bool   $skip
     *
     * @return string
     */
    protected function getValueOfFormatCharacter(string $name, bool &$skip = false): string
    {
        if (($r = $this->shouldWeSkip($name, $skip)) !== false) {
            return ''.$r;
        }

        if ($this->isOverrideFormatCharacter($name)) {
            return ''.$this->{Constants::FORMAT_MAPPER[$name]}();
        }

        return $this->dateTime->format($name);
    }

    /**
     * (01-30) Day of the month, 2 digits with leading zeros.
     *
     * @return string
     */
    public function getDayTwoDigit(): string
    {
        $day = $this->getValueOfFormatCharacter('j');

        return strlen($day) === 1 ? "0$day" : $day;
    }

    /**
     * (ሰኞ-እሑድ) A full textual representation of the day of the week.
     *
     * return string
     */
    public function getTextualDay(): string
    {
        return Constants::WEEK_NAME[$this->getDayOfWeek()];
    }

    /**
     * (ሰኞ-እሑ) A textual representation of a day, two letters.
     *
     * return string
     */
    public function getTextualDayShort(): string
    {
        $week = $this->getValueOfFormatCharacter('l');

        return mb_substr($week, 0, 2, 'UTF-8');
    }

    /**
     * (መስከረም-ጳጉሜን) A full textual representation of a month.
     *
     * @return string
     */
    public function getTextualMonth(): string
    {
        return Constants::MONTHS_NAME[$this->getMonth()];
    }

    /**
     * (መስ - ጳጉ) A short textual representation of a month, two letters.
     *
     * @return string
     */
    public function getTextualMonthShort(): string
    {
        $F = $this->getValueOfFormatCharacter('F');

        return mb_substr($F, 0, 2, 'UTF-8');
    }

    /**
     * (01-13) Numeric representation of a month, with leading zeros.
     *
     * @return string
     */
    public function getMonthTwoDigit(): string
    {
        $n = $this->getValueOfFormatCharacter('n');

        return (strlen($n) === 1) ? "0$n" : "$n";
    }

    /**
     * (1 or 0) Whether it's a leap year.
     *
     * @return string
     */
    public function getLeapYearString(): string
    {
        return $this->isLeapYear() ? '1' : '0';
    }

    /**
     * returns 97 for the year 1997.
     *
     * @return string
     */
    public function getYearShort(): string
    {
        $Y = $this->getValueOfFormatCharacter('Y');

        return mb_substr($Y, strlen($Y) - 2, 2);
    }

    /**
     * Return the amharic equivalent of AM & PM.
     *
     * (እኩለ፡ሌሊት-ምሽት)
     *
     * It suppose to format 'Ante meridiem' and 'Post meridiem'
     * But we Ethiopians classify the day in <b>ten</b> parts
     * and we don't have Uppercase and Lowercase letters
     *
     * @link http://web.archive.org/web/20140331152859/http://ethiopic.org/Calendars/
     *
     * @return string
     */
    public function getTimeOfDay(): string
    {
        $array = [
            'እኩለ፡ሌሊት'  => [23, 0],
            'ውደቀት'     => [1, 2, 3],
            'ንጋት'      => [4, 5],
            'ጡዋት'      => [6, 7, 8],
            'ረፋድ'      => [9, 10, 11],
            'እኩለ፡ቀን'   => [12],
            'ከሰዓት፡በኋላ' => [13, 14, 15],
            'ወደማታ'     => [16, 17],
            'ሲደነግዝ'    => [18, 19],
            'ምሽት'      => [20, 21, 22],
        ];

        $hour = $this->getHour();

        $result = array_filter($array, function ($value) use ($hour) {
            return in_array($hour, $value, true);
        });

        return key($result);
    }

    /**
     * 1 (for 'ልደታ'), 2 (for አባ፡ጉባ), ... 30 (for ማርቆስ).
     *
     * @return string the ethiopian orthodox day name
     */
    public function getOrthodoxDay(): string
    {
        return Constants::ORTHODOX_DAY_NAME[$this->getDay()];
    }

    /**
     * ዓ/ም or ዓ/ዓ.
     *
     * @return string
     */
    public function getTextualEra(): string
    {
        return $this->getYear() > 0 ? 'ዓ/ም' : 'ዓ/ዓ';
    }

    /**
     * ማቴዎስ, ማርቆስ, ሉቃስ or ዮሐንስ.
     *
     * @return string the ethiopian orthodox year name
     */
    public function getOrthodoxYear(): string
    {
        return Constants::ORTHODOX_YEAR_NAME[$this->getYear() % 4];
    }

    /**
     * Return the year in geez number.
     *
     * @throws \Geezify\Exception\NotAnIntegerArgumentException
     *
     * @return string
     */
    public function getYearInGeez(): string
    {
        return Geezify::create()->toGeez($this->getYear());
    }

    /**
     * Return the day in geez number.
     *
     * @return string
     */
    public function getDayInGeez(): string
    {
        return Geezify::create()->toGeez($this->getDay());
    }

    /**
     * Return an empty string.
     *
     * @return string
     */
    public function getTimeZoneString(): string
    {
        $name = $this->getTimezone()->getName();

        return Constants::TIME_ZONES[$name] ?? sprintf('ጂ ኤም ቲ%s', $name);
    }

    /**
     * Return `ኛው` rather than st,nd,rd, and th.
     *
     * @return string
     */
    public function getOrdinalSuffix(): string
    {
        return 'ኛው';
    }

    /**
     * RFC 2822 formatted date.
     *
     * @return string
     */
    public function getFormattedDate(): string
    {
        return $this->format(DATE_RFC2822);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function isOverrideFormatCharacter($name): bool
    {
        return array_key_exists($name, Constants::FORMAT_MAPPER);
    }

    /**
     * @param string $name
     * @param bool   $skip
     *
     * @return string|false
     */
    protected function shouldWeSkip($name, &$skip)
    {
        if ($this->shouldWeSkip4Real($name, $skip)) {
            return $this->skipCharacter($name, $skip);
        }

        return false;
    }

    /**
     * @param $name
     * @param $skip
     *
     * @return bool
     */
    protected function shouldWeSkip4Real($name, &$skip): bool
    {
        return $this->isSkipCharacter($name) || $skip;
    }

    /**
     * @param $name
     * @param $skip
     *
     * @return string
     */
    protected function skipCharacter($name, &$skip): string
    {
        if ($skip) {
            $skip = false;

            return $name;
        }

        if ($this->isSkipCharacter($name)) {
            $skip = true;
        }

        return '';
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function isSkipCharacter($name): bool
    {
        return $name === '\\';
    }
}
