# Andegna Calender ![From Ethiopia](https://img.shields.io/badge/From-Ethiopia-brightgreen.svg)

![Build Status](https://github.com/andegna/calender/actions/workflows/tests.yml/badge.svg)
[![StyleCI](https://styleci.io/repos/30183050/shield)](https://styleci.io/repos/30183050)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/calender/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/andegna/calender/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![Total Downloads](https://poser.pugx.org/andegna/calender/d/total.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Stable Version](https://poser.pugx.org/andegna/calender/v/stable.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Unstable Version](https://poser.pugx.org/andegna/calender/v/unstable.svg)](https://packagist.org/packages/andegna/calender)
[![License](https://poser.pugx.org/andegna/calender/license.svg)](https://packagist.org/packages/andegna/calender)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fandegna%2Fcalender.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fandegna%2Fcalender?ref=badge_shield)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1f0da300-92cf-4e9d-ba5a-f4fc30697ae9/big.png)](https://insight.sensiolabs.com/projects/1f0da300-92cf-4e9d-ba5a-f4fc30697ae9)

> If you ever want to convert **Ethiopian Calender** to any other calendar system
> (like the Gregorian Calendar) this is the right (well-tested, well designed, high quality) package for you.
>
> And by the way it also supports Amharic date formatting and much much more.

<a name="top"></a>

- [Basic Usage](#basic-usage-hammer)
- [Requirement](#requirement)
- [Installation](#installation)
- [Conversion](#conversion)
    - [From Ethiopian Date](#from-Ethiopian-Date)
    - [From Timestamp](#from-timestamp)
    - [From DateTime object](#from-dateTime-object)
    - [From date string](#from-date-string)
    - [From the system time](#from-the-system-time)
    - [To DateTime](#to-datetime)
- [Low level Conversion](#low-level-conversion)
    - [How PHP calendar conversion works](#how-php-calendar-conversion-works)
    - [From JDN](#from-jdn)
    - [To JDN](#to-jdn)
    - [Practical Example](#practical-example)
- [Manipulation](#manipulation)
    - [Warning](#warning)
    - [Manipulating the internal date time](#manipulating-the-internal-date-time)
- [Formatting](#formatting)
    - [Introduction](#introduction)
    - [Additional character formats](#additional-character-formats)
    - [Constants](#constants)
- [Holidays](#holidays)
    - [Easter](#easter)
- [Validators](#validators)
- [Contributing](#contributing)

<a name="basic-usage-hammer"></a> 
## Basic Usage :hammer: [&uarr;](#top)

Just to give you the 10,000-foot view (:airplane:) of the package.

```php
// create a gregorian date using PHP's built-in DateTime class
$gregorian = new DateTime('next monday');

// just pass it to Andegna\DateTime constractor and you will get $ethiopian date
$ethipic = new Andegna\DateTime($gregorian);
```

Format it

```php
// format it
// ሰኞ፣ ግንቦት ፯ ቀን (ሥላሴ) 00:00:00 እኩለ፡ሌሊት EAT ፳፻፱ (ማርቆስ) ዓ/ም
echo $ethipic->format(Andegna\Constants::DATE_GEEZ_ORTHODOX);

// ሰኞ፣ ግንቦት 07 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2009 ዓ/ም
echo $ethipic->format(Andegna\Constants::DATE_ETHIOPIAN);
```

Modify it

```php
$ethipic->modify('+8 hours');
$ethipic->sub(new DateInterval('PT30M')); // 30 minutes

// ሰኞ, 07-ግን-2009 07:30:00 EAT
echo $ethipic->format(DATE_COOKIE);
```

Get what you want :wink:

```php
echo $ethipic->getYear();   // 2009
echo $ethipic->getMonth();  // 9
echo $ethipic->getDay();    // 7

echo $ethipic->getTimestamp(); // 1494822600

// turn it back to gregorian 
// Monday, 15-May-2017 07:30:00 EAT
echo $ethipic->toGregorian()->format(DATE_COOKIE);
```

<a name="requirement"></a>
## Requirement [&uarr;](#top)

Andegna Calender requires `php: >=7.0` with fire and blood :fire: :dragon:. 

Please notice the name of this package is `andegna/calender` not `andegna/calendar`.
It's a spelling mistake am not intending to fix.

<a name="installation"></a>
## Installation [&uarr;](#top)

**Andegna Calender** utilizes [Composer](https://getcomposer.org/) to manage its dependencies. 
So, before using this, make sure you have Composer installed on your machine.

> Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.

If you never used composer before :flushed:, PLEASE read some [intro here](https://getcomposer.org/doc/00-intro.md) before you write any PHP code again.

```bash
composer require andegna/calender
```

<a name="conversion"></a>
## Conversion [&uarr;](#top)

Before we talk about calendar conversion, we better know how the `Andegna\DateTime` class works internally.

The `Andegna\DateTime` class is just a wrapper around PHP's built-in [`DateTime`](http://uk1.php.net/manual/en/class.datetime.php) 
object and implements the PHP [`DateTimeInterface`](http://uk1.php.net/manual/en/class.datetimeinterface.php) 
(OK! I lied on one part but trust me you don't wanna know that :smile:).

So `Andegna\DateTime` keep hold of the gregorian date and overrides the `format`, `getTimestamp`, `add`, 'diff' and such methods to give you an Ethiopian Calendar equivalent.

That's how it basically works.

<a name="from-Ethiopian-Date"></a>
### From Ethiopian Date [&uarr;](#top)

You can create an `Andegna\DateTime` from a given Ethiopia Date.

Let's "create"

```php
$millennium = Andegna\DateTimeFactory::of(2000, 1, 1);

// ረቡዕ፣ መስከረም 01 ቀን (ልደታ) 00:00:00 እኩለ፡ሌሊት EAT 2000 (ማቴዎስ) ዓ/ም
echo $millennium->format(\Andegna\Constants::DATE_ETHIOPIAN_ORTHODOX).PHP_EOL;

// Wednesday, 12-Sep-2007 00:00:00 EAT
echo $millennium->toGregorian()->format(DATE_COOKIE).PHP_EOL;

$fall_of_derg = Andegna\DateTimeFactory::of(1983, 9, 20, 7, 43, 21, new DateTimeZone('Africa/Addis_Ababa'));

// ማክሰኞ፣ ግንቦት 20 ቀን (ሕንፅተ) 07:43:21 ጡዋት EAT 1983 (ዮሐንስ) ዓ/ም
echo $fall_of_derg->format(\Andegna\Constants::DATE_ETHIOPIAN_ORTHODOX).PHP_EOL;

// Tuesday, 28-May-1991 07:43:21 EAT
echo $fall_of_derg->toGregorian()->format(DATE_COOKIE).PHP_EOL;
```

<a name="from-timestamp"></a>
### From Timestamp [&uarr;](#top)

Let's assume you have a timestamp from same were probably `time()` function or from some kind of database. 

You can get `Andegna\DateTime` object like this
```php
$timestamp = time(); // or some other place ¯\_(ツ)_/¯

$ethipic = Andegna\DateTimeFactory::fromTimestamp($timestamp);
```

And you are done. You can also or pass a `DateTimeZone` object if you want too

```php
$sheger = new DateTimeZone('Africa/Addis_Ababa');

$ethiopic = Andegna\DateTimeFactory::fromTimestamp($timestamp, $sheger);
```

<a name="from-dateTime-object"></a>
### From DateTime object [&uarr;](#top)

If you already have a `DateTime` object, just give it to me :smile:

```php
$gregorian = new DateTime('Thu, 11 May 2017 19:01:26 GMT');
$ethiopic = Andegna\DateTimeFactory::fromDateTime($gregorian);

// or just pass it through the constractor
$ethiopic = new Andegna\DateTime(new DateTime('next sunday'));
```

<a name="from-date-string"></a>
### From date string [&uarr;](#top)

This is not actually part of this package but someone probably having a hard time.

It generally boils down to two options. Do you know the format of the date string or not.

If you know the format of the date (you probably should) you can create a gregorian `DateTime`
like this

```php
// passing the format followed by the date string you got
$gregorian1 = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
$gregorian2 = DateTime::createFromFormat('m-j-Y', '12-31-1999');
$gregorian3 = DateTime::createFromFormat('Y-m-d H:i:s', '2009-02-15 15:16:17');
```

To figure out the format please check [this link](http://php.net/manual/en/datetime.createfromformat.php) or search for "PHP date function".

But if don't know the format is or don't care to figure it out just try to pass it to the DateTime constructor. It will "probably" figure out the format of the date string

```php
$gregorian1 = new DateTime('next sunday');
$gregorian2 = new DateTime('yesterday');
$gregorian3 = new DateTime('1999-12-31');
$gregorian4 = new DateTime('2123-12-31 12:34:56');

$gregorian_bad = new DateTime('12-31-1999'); // this one probably fails
```

<a name="from-the-system-time"></a>
### From the system time [&uarr;](#top)

You obviously can do this
```php
$gregorian = new DateTime('now');
$ethiopic = Andegna\DateTimeFactory::fromDateTime($gregorian);

// but we provided some shortcuts
$now1 = \Andegna\DateTimeFactory::now();
$now2 = new DateTime();

// if you wanna specify time zone
$sheger = new DateTimeZone('Africa/Addis_Ababa');
$now3 = \Andegna\DateTimeFactory::now($sheger);
```

<a name="to-datetime"></a>
### To DateTime [&uarr;](#top)

If you want the internal `DateTime` object (A.K.A convert to gregorian calendar).

```php
// create some Ethiopian date how ever you want
$ethiopian_date = \Andegna\DateTimeFactory::now();

// you get a PHP DateTime object to play with
$gregorian = $now->toGregorian();
```
> Warning: the returned DateTime object is just a clone. So changes/modification to the returned object will not affect the Ethiopic date.

<a name="low-level-conversion"></a>
## Low level Conversion [&uarr;](#top)

If you are a geek like me, you are probably interested in Calendar coz it has Astronomy, Maths, and History.

<a name="how-php-calendar-conversion-works"></a>
### How PHP calendar conversion works [&uarr;](#top)

> The calendar extension presents a series of functions to simplify converting between different calendar formats (except Ethiopian). 
> The intermediary or standard it is based on is the **Julian Day Count**. The Julian Day Count is a count of days starting from January 1st, 4713 B.C. 
> To convert between calendar systems, you must first convert to Julian Day Count, then to the calendar system of your choice. 
> Julian Day Count is very different from the Julian Calendar! For more information on Julian Day Count, visit » [http://www.hermetic.ch/cal_stud/jdn.htm](http://www.hermetic.ch/cal_stud/jdn.htm).
> For more information on calendar systems visit » [http://www.fourmilab.ch/documents/calendar/](http://www.fourmilab.ch/documents/calendar/). Excerpts from this page are included in these instructions and are in quotes.

Those words are straight from the [php docs](http://php.net/manual/en/intro.calendar.php).

So we need to implement two things to convert Ethiopian date to any other calendar.
 1. Convert Ethiopian Date To Julian Date Count
 2. Convert Julian Date Count To Ethiopian Date

If you wanna know the algorithms check out the only reliable resource at [this link](http://web.archive.org/web/20140331152859/http://ethiopic.org/Calendars/).

or check out my gist on GitHub at [this link](https://gist.github.com/SamAsEnd/70f2587c002070d2a1985f0741111554)

<a name="from-jdn"></a>
### From JDN [&uarr;](#top)

```php
use Andegna\Converter\FromJdnConverter;

$jdn = 2457886;
$converter = new FromJdnConverter($jdn);

$day = $converter->getDay();     // 4
$month = $converter->getMonth(); // 9
$year = $converter->getYear();   // 2009
```

<a name="to-jdn"></a>
### To JDN [&uarr;](#top)

```php
use Andegna\Converter\ToJdnConverter;

$converter = new ToJdnConverter(21,3,1986);
echo $jdn = $converter->getJdn();  // 2449322
```

<a name="practical-example"></a>
### Practical Example [&uarr;](#top)

Now with those handy tools in our hand, we can convert Ethiopian date to any other date.

Let's convert to Jewish for example

```php
$et = new Andegna\DateTime();

// ዓርብ, 04-ግን-2009 14:41:00 EAT
echo $et->format(DATE_COOKIE);

// create a Ethiopian Date `ToJdnConverter`
$converter = new Andegna\Converter\ToJdnConverter($et->getDay(), $et->getMonth(), $et->getYear());

// convert it to jdn
$jdn = $converter->getJdn();

// use the built-in php function to convert the jdn to the jewish calendar 
$jewish_date1 = jdtojewish($jdn);

// 9/16/5777
echo $jewish_date1;

// it also support formating for the return string
$jewish_date2 = jdtojewish($jdn, true,     CAL_JEWISH_ADD_ALAFIM_GERESH);

// convert the return string to utf-8
$jewish_date2 = iconv ('WINDOWS-1255', 'UTF-8', $jewish_date2); 

// טז אייר ה'תשעז
echo $jewish_date2;
```

Let's convert Julian Calendar to Ethiopian Calendar as a second example

```php
$day = 29;
$month = 4;
$year = 2017;

// get the jdn using the built in php function
$jdn = juliantojd($month, $day, $year);

// convert the jd to Ethiopian Date
$converter = new Andegna\Converter\FromJdnConverter($jdn);

// create a `Andegna\DateTime` from the converted date
$ethiopic = Andegna\DateTimeFactory::fromConverter($converter);

// ዓርብ, 04-ግን-2009 00:00:00 EAT
echo $ethiopic->format(DATE_COOKIE);

// Friday, 12-May-2017 00:00:00 EAT
echo $ethiopic->toGregorian()->format(DATE_COOKIE);
```

#### List of supported calendars built into PHP
- French Republican Calendar
- Gregorian Calendar
- Jewish calendar
- Julian Calendar
- Unix (I know what you are thinking. It's not a calendar but it handy)

Click [here](http://php.net/manual/en/ref.calendar.php) to read more about those calendar function

<a name="manipulation"></a>
## Manipulation [&uarr;](#top)

<a name="warning"></a>
### Warning [&uarr;](#top)

> The DateTime processor works on the internal gregorian `DateTime`. And manipulating months and years probably give an expected results.

<a name="manipulating-the-internal-date-time"></a>
### Manipulating the internal date time [&uarr;](#top)

You probably need to read about [DateTimeInterval](http://php.net/manual/en/class.dateinterval.php) if you don't already know.

To give you a short summary, `DateInterval` implements the [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601#Durations) durations.

Durations are a component of time intervals and define the amount of intervening time in a time interval.
Durations are represented by the format **`P[n]Y[n]M[n]DT[n]H[n]M[n]S`** or **`P[n]W`**. 

In these representations, the [n] is replaced by the value for each of the date and time elements that follow the [n]. 

Leading zeros are not required. The capital letters P, Y, M, W, D, T, H, M, and S are designators for each of the date and time elements and are not replaced.

- **P** is the duration designator (for the period) placed at the start of the duration representation.
- **Y** is the year designator that follows the value for the number of years.
- **M** is the month designator that follows the value for the number of months.
- **W** is the week designator that follows the value for the number of weeks.
- **D** is the day designator that follows the value for the number of days.
- **T** is the time designator that precedes the time components of the representation.
- **H** is the hour designator that follows the value for the number of hours.
- **M** is the minute designator that follows the value for the number of minutes.
- **S** is the second designator that follows the value for the number of seconds.

> For example, **"P3Y6M4DT12H30M5S"** represents a duration of "three years, six months, four days, twelve hours, thirty minutes, and five seconds".

```php
// let's start from today
$today = new Andegna\DateTime();

// Adds an amount of days, months, years, hours, minutes and seconds to a DateTime object
$tomorrow = $today->add(new DateInterval('P1D'));
$after_some_days = $today->add(new DateInterval('P10DT4H'));
$after_6_hours = $today->add(new DateInterval('PT6H'));

// Subtracts an amount of days, months, years, hours, minutes and seconds from a DateTime object
$yesterday = $today->sub(new DateInterval('P1D'));
$before_some_days = $today->sub(new DateInterval('P10DT4H'));
$before_6_hours = $today->sub(new DateInterval('PT6H'));

// Alters the DateTime object
$tomorrow = $today->modify('+1 day');
$yesterday = $today->modify('-1 day');
$after_30_minutes = $today->modify('+30 minutes');
$after_30_minutes = $today->modify('next sunday');
```

If you want to get the difference between dates

```php
$today = new Andegna\DateTime();
$tomorrow = (new Andegna\DateTime())->add(new DateInterval('P1DT2M3S'));

$diff = $today->diff($tomorrow); // returns a DateTimeInterval
var_dump($diff);
```

will output something like this
```
object(DateInterval)[9]
  ...
  public 'd' => int 1
  public 'h' => int 0
  public 'i' => int 2
  public 's' => int 3
  ...
```
<a name="formatting"></a>
## Formatting [&uarr;](#top)

<a name="introduction"></a>
### Introduction [&uarr;](#top)

PHP built-in `DateTime` class has a `format` method used to format dates.

> Read about the format method [here](http://uk1.php.net/manual/en/datetime.format.php)
> 
> Read out the format characters [here](http://uk1.php.net/manual/en/function.date.php)

If you read or already know how PHP date function works, you already know how exactly the formatting works.

```php
$now = new Andegna\DateTime();

// Let's play a game. It's called "Spot the difference"
echo $now->format(DATE_COOKIE);                   // ዓርብ, 04-ግን-2009 02:09:52 EAT
echo $now->toGregorian()->format(DATE_COOKIE);    // Friday, 12-May-2017 02:09:52 EAT

echo $now->format(DATE_ATOM);                      // 2009-09-04EAT02:09:52+03:00
echo $now->toGregorian()->format(DATE_ATOM);     // 2017-05-12T02:09:52+03:00

echo $now->format('F j ቀን Y');                    // ግንቦት 4 ቀን 2009
echo $now->toGregorian()->format('F j ቀን Y');     // May 12 ቀን 2017

echo $now->format('H:i:s A');                   // 10:09:17 ረፋድ
echo $now->toGregorian()->format('H:i:s A');    // 10:09:17 AM
```
<a name="additional-character-formats"></a>
### Additional character formats [&uarr;](#top)

| Format Character | Description       | Example |
| ---------------- | -------------     | ------- |
| x | Orthodox day name      | 1 => ልደታ, 12 => ሚካኤል       |
| X | Orthodox year name     | ማቴዎስ, ማርቆስ, ሉቃስ or ዮሐንስ  |
| E | Era in Amharic         | ዓ/ዓ or ዓ/ም                  |
| K | Year in geez numeber    | ፳፻፱                          |
| V | Day in geez numebr     | ፪                              |                

<a name="constants"></a>
### Constants [&uarr;](#top)

We have already defined some handy constants to print as it's custom in Ethiopia :heart: .

```php
$date = new Andegna\DateTime();

// ዓርብ፣ ግንቦት 04 ቀን 02:35:45 ውደቀት EAT 2009 ዓ/ም
echo $date->format(Andegna\Constants::DATE_ETHIOPIAN);

$date->modify('+8 hours');

// ዓርብ፣ ግንቦት 04 ቀን (ዮሐንስ) 10:35:45 ረፋድ EAT 2009 (ማርቆስ) ዓ/ም
echo $date->format(Andegna\Constants::DATE_ETHIOPIAN_ORTHODOX);

$date->modify('+1 year');

// ቅዳሜ፣ ግንቦት ፬ ቀን 10:35:45 ረፋድ EAT ፳፻፲ ዓ/ም
echo $date->format(Andegna\Constants::DATE_GEEZ);

$date->modify('-3 years')->modify('+1 day');

// ረቡዕ፣ ግንቦት ፭ ቀን (አቦ) 10:35:45 ረፋድ EAT ፳፻፯ (ዮሐንስ) ዓ/ም
echo $date->format(Andegna\Constants::DATE_GEEZ_ORTHODOX);
```

As you saw 3D, the constants all start with `DATE_` and followed by `ETHIOPIAN` or `GEEZ`.

The one followed by `GEEZ` will return the day and the year in geez and the `ETHIOPIAN` with spit an ASCII numbers which we Ethiopian always use.

Lastly, if you append `_ORTHODOX` you will get the orthodox day name and orthodox year name.

<a name="holidays"></a>
## Holidays [&uarr;](#top)

<a name="easter"></a>
### Easter [&uarr;](#top)

Calculating easter date feels like shooting a moving target. And everyone thinks calculating easter date is like impossible, some think like it's only possible if you are a deeply religious and some think it's decided by the church. But calculating easter date ( also called Computus) is not that much complex. 

In the simplest form, Easter is the first Sunday following the full moon that follows the northern spring (vernal) equinox.

That sounds complex and was hard for the ages but not for the 21st century.

If you are interested in HOW it's calculated, I will post it on my upcoming blog.
You can read [this](https://en.wikipedia.org/wiki/Computus) in the meanwhile.

Let's see how you can get the easter date for a given year

```php
$easter = new Andegna\Holiday\Easter();

// እሑድ፣ ሚያዝያ 08 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2009 ዓ/ም
echo $easter->get(2009)->format(Andegna\Constants::DATE_ETHIOPIAN).PHP_EOL;

// or just ...
foreach ([2006,2007,2008,2009,2010,2011,2012] as $year) {
    echo $easter->get($year)->format(Andegna\Constants::DATE_ETHIOPIAN).PHP_EOL;
}
```
will output
```
እሑድ፣ ሚያዝያ 12 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2006 ዓ/ም
እሑድ፣ ሚያዝያ 04 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2007 ዓ/ም
እሑድ፣ ሚያዝያ 23 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2008 ዓ/ም
እሑድ፣ ሚያዝያ 08 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2009 ዓ/ም
እሑድ፣ መጋቢት 30 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2010 ዓ/ም
እሑድ፣ ሚያዝያ 20 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2011 ዓ/ም
እሑድ፣ ሚያዝያ 11 ቀን 00:00:00 እኩለ፡ሌሊት EAT 2012 ዓ/ም
```

<a name="validators"></a>
## Validators [&uarr;](#top)

Validation. You probably need that too.

To check if Ethiopia date (given `day`, `month` and `year`) is valid you need to do all this

 - Check if the `day` is between `1` and `30` inclusive
 - Check if the `month` is between `1` and `13` inclusive
 - If the `month` is `13` check if the `day` is between `1` and `6` inclusive
 - If the `month` is `13` and the `day` is `6` check if the year is a leap year

or you can use our validator

#### DateValidator

```php
use Andegna\Validator\DateValidator;

// true
$is_valid1 = (new DateValidator(15,9, 2009))->isValid();

// false
$is_valid2 = (new DateValidator(6,13, 2009))->isValid();
```

#### LeapYearValidator

```php
use Andegna\Validator\LeapYearValidator;

// false
$is_valid3 = (new LeapYearValidator(2009))->isValid();

// true
$is_valid4 = (new LeapYearValidator(2007))->isValid();
```

<a name="contributing"></a>
## Contributing [&uarr;](#top)

    Fork it
    Create your feature branch (git checkout -b my-new-feature)
    Commit your changes (git commit -am 'Add some feature')
    Push to the branch (git push origin my-new-feature)
    Create new Pull Request


## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fandegna%2Fcalender.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fandegna%2Fcalender?ref=badge_large)
