<?php

namespace Andegna\Ethiopian;

use InvalidArgumentException;

/**
 * Trait DateFormatter
 *
 * This trait deals with the date time formatting issue
 *
 * @package Andegna\Ethiopian
 */
trait DateFormatter
{

    /**
     * I got the Magic :) call
     *
     * @param $name
     * @param $arguments
     * @return int|string
     */
    function __call($name, $arguments)
    {
        $field = $this->extractCalledField($name);

        if (property_exists($this, $field)) {
            return $this->{$field};
        }

        if (array_key_exists($field, $formats = [
            'hour' => 'G',
            'minute' => 'i',
            'second' => 's',
            'micro' => 'u',
            'dayOfWeek' => 'N',
            'timestamp' => 'U'])) {
            return (int)$this->format($formats[$field]);
        }

        return $this->format($field);
    }

    /**
     * Extract the name of the getter function
     *
     * eg: given 'getDayOfWeek' return 'dayOfWeek'
     *     given 'isFinished' return 'finished'
     *
     * @param $name
     * @return string
     */
    protected function extractCalledField($name)
    {
        if (strpos($name, 'get') === 0) {
            return lcfirst(substr($name, 3));
        } elseif (strpos($name, 'is') === 0) {
            return lcfirst(substr($name, 2));
        } else {
            throw new InvalidArgumentException(sprintf("Unknown getter '%s'", $name));
        }
    }

    /**
     * Accepts the same format as the date() function
     *
     * @see date(), \DateTime
     *
     * @param $format
     * @return string
     */
    public function format($format)
    {
        $result = "";
        /** @var integer $length */
        $length = mb_strlen($format);

        // iterate for each character
        for ($index = 0; $index < $length; $index++) {
            $result .= $this->getValueOfFormatCharacter($format[$index]);
        }

        return $result;
    }

    /**
     * Return the value of the format character
     *
     * @param string $name of the field
     * @return string
     */
    protected function getValueOfFormatCharacter($name)
    {
        switch ($name) {
            // (01-30) Day of the month, 2 digits with leading zeros
            case 'd':
                $d = $this->getValueOfFormatCharacter('j');

                if (strlen($d) == 1) {
                    return "0$d";
                }

                return $d;

            // (ሰኞ-እሑ) A textual representation of a day, two letters
            case 'D':
                $week = $this->getValueOfFormatCharacter('l');
                return mb_substr($week, 0, 2, 'UTF-8');

            // (1-30) Day of the month without leading zeros
            case 'j':
                return "{$this->getDay()}";

            // (ሰኞ-እሑድ) A full textual representation of the day of the week
            case 'l': // l (lowercase 'L')
                return self::WEEK_NAME_AM[$this->getDayOfWeek()];

            // This should be the "English" ordinal suffix for the day of the month
            // 2 characters so am gonna just return the letter 'ኛ'
            case 'S':
                return 'ኛ';

            // (0-365) The day of the year (starting from 0)
            case 'z':
                return "{$this->getDayOfYear()}";

            // ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)
            case 'W':
                return "{$this->getIsoWeekNumber()}";

            // (መስከረም-ጳጉሜን) A full textual representation of a month
            case 'F':
                return self::MONTHS_NAME[$this->getMonth()];

            // (01-13) Numeric representation of a month, with leading zeros
            case 'm':
                $n = $this->getValueOfFormatCharacter('n');
                return (strlen($n) == 1) ? "0$n" : "$n";

            // (መስ - ጳጉ) A short textual representation of a month, two letters
            case 'M':
                $F = $this->getValueOfFormatCharacter('F');
                return mb_substr($F, 0, 2, 'UTF-8');

            // (1-13) Numeric representation of a month, without leading zeros
            case 'n':
                return "{$this->getMonth()}";

            // (5,6 or 30) Number of days in the given month
            case 't':
                return "{$this->getDaysInMonth()}";

            // (1 or 0) Whether it's a leap year
            case 'L':
                return $this->isLeapYear() ? '1' : '0';

            // ISO-8601 year number. This has the same value as Y, except that if
            // the ISO week number (W) belongs to the previous or next year,
            // that year is used instead. (added in PHP 5.1.0)
            case 'o':
                // TODO: Research if the ISO 8601 week number apply for our calender
                return "{$this->getIsoYearNumber()}";

            // (1000-9999) A full numeric representation of a year, 4 digits mostly
            case 'Y':
                return "{$this->getYear()}";

            // (00-99) A two digit representation of a year
            case 'y':
                $Y = $this->getValueOfFormatCharacter('Y');
                return mb_substr($Y, strlen($Y) - 2, 2);

            // (እኩለ፡ሌሊት-ምሽት)
            // It suppose to format 'Ante meridiem' and 'Post meridiem'
            // But we Ethiopians classify the day in <b>ten</b> parts
            // and we don't have Uppercase and Lowercase letters
            case 'a': // Lowercase
            case 'A': // Uppercase
                return $this->getTimeOfDay();

            // (Y-m-d\TH:i:sO) as of The ISO 8601 standard
            case 'c':
                return $this->format(DATE_ISO8601);

            // (D, d M Y H:i:s O) as of The RFC 2822 standard
            case 'r':
                return $this->format(DATE_RFC2822);

            // if the format character is not defined here
            // implies it doesn't depend on calender like 'hour'
            // or it is not a format character like '-'
            default:
                return $this->dateTime->format($name);
        }
    }

    /**
     * Return the amharic equivalent of AM & PM
     *
     * @link http://web.archive.org/web/20140331152859/http://ethiopic.org/Calendars/
     * @return string
     */
    public function getTimeOfDay()
    {
        switch ($this->getHour()) {
            case 23:
            case 0:
                return 'እኩለ፡ሌሊት';
            case 1:
            case 2:
            case 3:
                return 'ውደቀት';
            case 4:
            case 5:
                return 'ንጋት';
            case 6:
            case 7:
            case 8:
                return 'ጡዋት';
            case 9:
            case 10:
            case 11:
                return 'ረፋድ';
            case 12:
                return 'እኩለ፡ቀን';
            case 13:
            case 14:
            case 15:
                return 'ከሰዓት፡በኋላ';
            case 16:
            case 17:
                return 'ወደማታ';
            case 18:
            case 19:
                return 'ሲደነግዝ';
            case 20:
            case 21:
            case 22:
                return 'ምሽት';
        }

        // We shouldn't get to this :(
        // Something must been wrong

        // Lets just keep quite about it :)
        return '';
    }
}
