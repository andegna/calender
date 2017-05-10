<?php

namespace Andegna;

/**
 * Ethiopian Date Constants.
 */
class Constants
{
    const DATE_ETHIOPIAN = 'l፣ F d ቀን H:i:s a T Y E';
    const DATE_ETHIOPIAN_ORTHODOX = 'l፣ F d ቀን (x) H:i:s a T Y (X) E';

    const DATE_GEEZ = 'l፣ F V ቀን H:i:s a T K E';
    const DATE_GEEZ_ORTHODOX = 'l፣ F V ቀን (x) H:i:s a T K (X) E';

    const MONTHS_NAME = [
        1 => 'መስከረም', 'ጥቅምት', 'ኅዳር', 'ታኅሣሥ', 'ጥር', 'የካቲት',
        'መጋቢት', 'ሚያዝያ', 'ግንቦት', 'ሰኔ', 'ሐምሌ', 'ነሐሴ', 'ጳጉሜን', ];

    const WEEK_NAME = [1 => 'ሰኞ', 'ማክሰኞ', 'ረቡዕ', 'ሓሙስ', 'ዓርብ', 'ቅዳሜ', 'እሑድ'];

    const ORTHODOX_YEAR_NAME = ['ማቴዎስ', 'ማርቆስ', 'ሉቃስ', 'ዮሐንስ'];

    const ORTHODOX_DAY_NAME = [
        1 => 'ልደታ', 'አባ፡ጉባ', 'በእታ', 'ዮሐንስ', 'አቦ',
        'ኢያሱስ', 'ሥላሴ', 'አባ፡ኪሮስ', 'ቶማስ', 'መስቀል',
        'ሐና፡ማርያም', 'ሚካኤል', 'እግዚሐር፡አብ', 'አቡነ፡አረጋዊ',
        'ቂርቆስ', 'ኪዳነ፡ምሕረት', 'እስጢፋኖስ', 'ተክለ፡አልፋ',
        'ገብርኤል', 'ሕንፅተ', 'ማርያም', 'ኡራኤል', 'ጊዮርጊስ',
        'ተክለ፡ሐይማኖት', 'መርቆርዮስ', 'ዮሴፍ', 'መድኀኔ፡ዓለም',
        'አማኑኤል', 'ባለ፡እግዚአብሔር', 'ማርቆስ',
    ];

    const FORMAT_MAPPER = [
        'j' => 'getDay',                        //  1 - 30
        'd' => 'getDayTwoDigit',                //	01 - 30
        'l' => 'getTextualDay',                 //  ሰኞ - እሑድ
        'D' => 'getTextualDayShort',            //	ሰኞ - እሑ
        'w' => 'getDayOfWeek',                  //  0 እሑድ - 6 ሰኞ
        'z' => 'getDayOfYear',                  //  0 - 365

        'F' => 'getTextualMonth',               //  መስ - ጳጉ
        'M' => 'getTextualMonthShort',          //  መስ - ጳጉ
        'n' => 'getMonth',                      //  1 - 13
        'm' => 'getMonthTwoDigit',              //  01 - 13
        't' => 'getDaysInMonth',                //  5 - 30

        'L' => 'getLeapYearString',             //  0 - 1
        'Y' => 'getYear',                       //  2009
        'y' => 'getYearShort',                  //  09
        'a' => 'getTimeOfDay',                  //	እኩለ፡ሌሊት-ምሽት
        'A' => 'getTimeOfDay',                  //	እኩለ፡ሌሊት-ምሽት

        // custom
        'x' => 'getOrthodoxDay',                //  ልደታ - ማርቆስ
        'X' => 'getOrthodoxYear',               //  ማቴዎስ - ዮሐንስ
        'E' => 'getTextualEra',                 //  ዓ/ዓ, ዓ/ም

        'K' => 'getYearInGeez',                 //  ፳፻፱
        'V' => 'getDayInGeez',                  //  ፪
    ];
}
