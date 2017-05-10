<?php

namespace Andegna\Operations;

use Andegna\Constants;

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
    public function format($format)
    {
        $result = '';
        $length = \mb_strlen($format);

        // iterate for each character
        for ($index = 0; $index < $length; $index++) {
            $result .= $this->getValueOfFormatCharacter(mb_substr($format, $index, 1));
        }

        return $result;
    }

    /**
     * Return the value of the format character.
     *
     * @param string $name of the field
     *
     * @return string
     */
    protected function getValueOfFormatCharacter($name)
    {
        if (array_key_exists($name, Constants::FORMAT_MAPPER)) {
            return '' . $this->{Constants::FORMAT_MAPPER[$name]}();
        }

        return $this->dateTime->format($name);
    }

    /**
     * (01-30) Day of the month, 2 digits with leading zeros
     *
     * @return string
     */
    public function getDayTwoDigit()
    {
        $day = $this->getValueOfFormatCharacter('j');

        return strlen($day) === 1 ? "0$day" : $day;
    }

    /**
     * (ሰኞ-እሑድ) A full textual representation of the day of the week
     *
     * return string
     */
    public function getTextualDay()
    {
        return Constants::WEEK_NAME[$this->getDayOfWeek()];
    }

    /**
     * (ሰኞ-እሑ) A textual representation of a day, two letters
     *
     * return string
     */
    public function getTextualDayShort()
    {
        $week = $this->getValueOfFormatCharacter('l');

        return mb_substr($week, 0, 2, 'UTF-8');
    }

    /**
     * (መስከረም-ጳጉሜን) A full textual representation of a month
     *
     * @return string
     */
    public function getTextualMonth()
    {
        return Constants::MONTHS_NAME[$this->getMonth()];
    }

    /**
     * (መስ - ጳጉ) A short textual representation of a month, two letters
     *
     * @return string
     */
    public function getTextualMonthShort()
    {
        $F = $this->getValueOfFormatCharacter('F');

        return mb_substr($F, 0, 2, 'UTF-8');
    }

    /**
     * (01-13) Numeric representation of a month, with leading zeros
     *
     * @return string
     */
    public function getMonthTwoDigit()
    {
        $n = $this->getValueOfFormatCharacter('n');

        return (strlen($n) == 1) ? "0$n" : "$n";
    }

    /**
     * (1 or 0) Whether it's a leap year
     *
     * @return string
     */
    public function getLeapYearString()
    {
        return $this->isLeapYear() ? '1' : '0';
    }

    /**
     * returns 97 for the year 1997
     *
     * @return string
     */
    public function getYearShort()
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
    public function getTimeOfDay()
    {
        $array = [
            23 => 'እኩለ፡ሌሊት',
            0 => 'እኩለ፡ሌሊት',

            1 => 'ውደቀት',
            2 => 'ውደቀት',
            3 => 'ውደቀት',


            4 => 'ንጋት',
            5 => 'ንጋት',

            6 => 'ጡዋት',
            7 => 'ጡዋት',
            8 => 'ጡዋት',

            9 => 'ረፋድ',
            10 => 'ረፋድ',
            11 => 'ረፋድ',

            12 => 'እኩለ፡ቀን',

            13 => 'ከሰዓት፡በኋላ',
            14 => 'ከሰዓት፡በኋላ',
            15 => 'ከሰዓት፡በኋላ',

            16 => 'ወደማታ',
            17 => 'ወደማታ',

            18 => 'ሲደነግዝ',
            19 => 'ሲደነግዝ',

            20 => 'ምሽት',
            21 => 'ምሽት',
            22 => 'ምሽት',
        ];

        return $array[$this->getHour()];
    }

    /**
     * 1 (for 'ልደታ'), 2 (for አባ፡ጉባ), ... 30 (for ማርቆስ)
     *
     * @return string the ethiopian orthodox day name
     */
    public function getOrthodoxDay()
    {
        return Constants::ORTHODOX_DAY_NAME[$this->getDay()];
    }

    /**
     * ዓ/ም or ዓ/ዓ
     *
     * @return string
     */
    public function getTextualEra()
    {
        return $this->getYear() > 0 ? 'ዓ/ም' : 'ዓ/ዓ';
    }

    /**
     * ማቴዎስ, ማርቆስ, ሉቃስ or ዮሐንስ
     *
     * @return string the ethiopian orthodox year name
     */
    public function getOrthodoxYear()
    {
        return Constants::ORTHODOX_YEAR_NAME[$this->getYear() % 4];
    }

}
