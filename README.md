# Andegna Calender ![From Ethiopia](https://img.shields.io/badge/From-Ethiopia-brightgreen.svg)

[![Build Status](https://travis-ci.org/andegna/calender.svg?branch=master)](https://travis-ci.org/andegna/calender)
[![StyleCI](https://styleci.io/repos/30183050/shield)](https://styleci.io/repos/30183050)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/calender/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/andegna/calender/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![Total Downloads](https://poser.pugx.org/andegna/calender/d/total.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Stable Version](https://poser.pugx.org/andegna/calender/v/stable.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Unstable Version](https://poser.pugx.org/andegna/calender/v/unstable.svg)](https://packagist.org/packages/andegna/calender)
[![License](https://poser.pugx.org/andegna/calender/license.svg)](https://packagist.org/packages/andegna/calender)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1f0da300-92cf-4e9d-ba5a-f4fc30697ae9/big.png)](https://insight.sensiolabs.com/projects/1f0da300-92cf-4e9d-ba5a-f4fc30697ae9)


> If you ever want to convert **Ethiopian Calender** to any other calender system
> (like the Gregorian Calender) this is the right (well tested && well designed) package for you.
>
> And by the way it also support Amharic date formatting and much much more.

- [Basic Usage](#basic-usage)
- [Requirement](#requirement)
- [Installation](#installation)
- [Conversion](#conversion)
    - [From Timestamp](#from-timestamp)
    - [From DateTime object](#from-dateTime-object)
    - [From date string](#from-date-string)
    - [From the system time](#from-the-system-time)
    - [To DateTime](#to-datetime)
- [Low level Conversion](#low-level-conversion)
	- [How PHP calender conversion works](#how-php-calender-conversion-works)
	- [From JDN](#from-jdn)
	- [To JDN](#to-jdn)
- [Manipulation](#manipulation)
	- [Warning](#warning)
	- [Manipulating the internal date time](#manipulating-the-internal-date-time)
- [Formatting](#formatting)
	- [Introduction](#introduction)
	- [Custom character formats](#custom-character-formats)
	- [Constants](#constants)
- [Holidays](#holidays)
	- [Eastern](#eastern)
- [Validators](#validators)
- [Available methods](#available-methods)
	- [Manipulation methods](#manipulation-methods)
	- [Getters](#getters)
- [Contributing](#contributing)

<a name="basic-usage"></a> 
## Basic Usage :hammer:

Just to give you the 10,000 foot view (:airplane:) of the package.

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
## Requirement

Andegna Calender requires `php: >=5.6` with fire and blood :fire: :dragon:. 

<a name="installation"></a>
## Installation

**Andegna Calender** utilizes [Composer](https://getcomposer.org/) to manage its dependencies. 
So, before using this, make sure you have Composer installed on your machine.

> Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.

If you never used composer before :flushed:, PLEASE read some [intro here](https://getcomposer.org/doc/00-intro.md) before you write any PHP code again.

```bash
composer require andegna/calender
```

<a name="conversion"></a>
## Conversion

Before we talk about calender conversion, we better know how the `Andegna\DateTime` class works internally.

The `Andegna\DateTime` class is just a wrapper around php's built-in [`DateTime`](http://uk1.php.net/manual/en/class.datetime.php) 
object and implements the php [`DateTimeInterface`](http://uk1.php.net/manual/en/class.datetimeinterface.php) 
(OK! I lied on one part but trust me you don't wanna know that :smile:).

So `Andegna\DateTime` keep hold of the gregorian date and overides the `format`, `getTimestamp`, `add`, 'diff' and such methods to give you an Ethiopian Calender equvalent.

That's how it basically works.

<a name="from-timestamp"></a>
### From Timestamp

Let's assume you have a timestamp from same where, probably `time()` function or from the some kind of database. 

You can get `Andegna\DateTime` object like this
```php
$timestamp = time(); // or some other place ¯\_(ツ)_/¯

$ethipic = Andegna\DateTimeFactory::fromTimestamp($timestamp);
```

And you are done. You can also or pass a `DateTimeZone` object if you want too

```php
$sheger = new DateTimeZone('Africa/Addis_Ababa');

$ethiopic = \Andegna\DateTimeFactory::fromTimestamp($timestamp, $sheger);
```

<a name="from-dateTime-object"></a>
### From DateTime object

If you already have a DateTime object, just give it to me :smile:

```php
$gregorian = new DateTime('now');
$ethiopic = Andegna\DateTimeFactory::fromDateTime($gregorian);

// or just pass it through the constractor
$ethiopic = new Andegna\DateTime(new DateTime('next sunday'));
```

<a name="from-the-system-time"></a>
### From the system time

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

<a name="from-date-string"></a>
### From date string

This is not actually part of this package but some one probably having a hard time.

It's generally boils down to two options. Do you know the format of the date or not.

If you know the format of the date(you probably should) u can create a gregorian `DateTime`
like this

```php
$gregorian1 = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
$gregorian2 = DateTime::createFromFormat('m-j-Y', '12-31-1999');
$gregorian3 = DateTime::createFromFormat('Y-m-d H:i:s', '2009-02-15 15:16:17');
```

To figure out the format please check [this](http://php.net/manual/en/datetime.createfromformat.php) out.

But if don't know the format is or don't care to check just try to pass it to the DateTime constractor.

```php
$gregorian1 = new DateTime('next sunday');
$gregorian2 = new DateTime('yesterday');
$gregorian3 = new DateTime('1999-12-31');
$gregorian4 = new DateTime('2123-12-31 12:34:56');

$gregorian_bad = new DateTime('12-31-1999'); // this one probably fails
```

<a name="to-datetime"></a>
### To DateTime

If you want the internal DateTime object

```php
$ethiopian_date = \Andegna\DateTimeFactory::now();
$gregorian = $now->toGregorian();
```
> Warning: the returned DateTime object is just a clone. So changed to the returned object will not affect the $ethiopic date.

<a name="low-level-conversion"></a>
## Low level Conversion

If you are a geek like me, you are probably interested in Calender coz it have 
Astronomy, Maths and History.

<a name="how-php-calender-conversion-works"></a>
### How PHP calender conversion works

> The calendar extension presents a series of functions to simplify converting between different calendar formats (except Ethiopian). 
> The intermediary or standard it is based on is the **Julian Day Count**. The Julian Day Count is a count of days starting from January 1st, 4713 B.C. 
> To convert between calendar systems, you must first convert to Julian Day Count, then to the calendar system of your choice. 
> Julian Day Count is very different from the Julian Calendar! For more information on Julian Day Count, visit » [http://www.hermetic.ch/cal_stud/jdn.htm](http://www.hermetic.ch/cal_stud/jdn.htm).
> For more information on calendar systems visit » [http://www.fourmilab.ch/documents/calendar/](http://www.fourmilab.ch/documents/calendar/). Excerpts from this page are included in these instructions, and are in quotes.

Those words are straight from the [php docs](http://php.net/manual/en/intro.calendar.php).

So we need to implement two thing.
 1. Convert Ethiopian Date To Julian Date Count
 2. Convert Julian Date Count To Ethiopian Date

If you wanna know the algorithms check out the only reliable resource at [this link](http://web.archive.org/web/20140331152859/http://ethiopic.org/Calendars/).

or check out my gist on github at [this link](https://gist.github.com/SamAsEnd/70f2587c002070d2a1985f0741111554)

<a name="from-jdn"></a>
### From JDN

```php
use Andegna\Converter\FromJdnConverter;

$jdn = 2457886;
$converter = new FromJdnConverter($jdn);

$day = $converter->getDay();     // 4
$month = $converter->getMonth(); // 9
$year = $converter->getYear();   // 2009
```

<a name="to-jdn"></a>
### To JDN

```php
use Andegna\Converter\ToJdnConverter;

$converter = new ToJdnConverter(21,3,1986);
echo $jdn = $converter->getJdn();  // 2449322
```

<a name="manipulation"></a>
## Manipulation

<a name="warning"></a>
### Warning

> The datetime processor works on the internal gregorian `DateTime`. And manipulating months and years probably gives an expected results.

<a name="manipulating-the-internal-date-time"></a>
### Manipulating the internal date time

You probably need to read about [DateTimeInterval](http://php.net/manual/en/class.dateinterval.php) if you don't already know.

```php
// let's start from today
$today = new \Andegna\DateTime();

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
$today = new \Andegna\DateTime();
$tomorrow = (new \Andegna\DateTime())->add(new DateInterval('P1DT2M3S'));

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
## Formatting

Formatting (A.K.A "the cool part")

<a name="introduction"></a>
### Introduction

PHP built-in `DateTime` class has a `format` method used to format dates.

> Read about the format method [here](http://uk1.php.net/manual/en/datetime.format.php)
> 
> Read out the format characters [here](http://uk1.php.net/manual/en/function.date.php)

If you read or already know how php date function works, you already know how exactly the formatting works.

```php
$now = new \Andegna\DateTime();

echo $now->format(DATE_COOKIE);   				// ዓርብ, 04-ግን-2009 02:09:52 EAT
echo $now->toGregorian()->format(DATE_COOKIE);	// Friday, 12-May-2017 02:09:52 EAT

echo $now->format(DATE_ATOM);  					// 2009-09-04EAT02:09:52+03:00
echo $now->toGregorian()->format(DATE_ATOM); 	// 2017-05-12T02:09:52+03:00

echo $now->format('F j ቀን Y');					// ግንቦት 4 ቀን 2009
echo $now->toGregorian()->format('F j ቀን Y'); 	// May 12 ቀን 2017

echo $now->format('H:i:s A');               	// 10:09:17 ረፋድ
echo $now->toGregorian()->format('H:i:s A');	// 10:09:17 AM
```
<a name="custom-character-formats"></a>
### Custom character formats

| Format Character | Description   	| Example |
| ---------------- | ------------- 	| ------- |
| x | Orthodox day name  	| 1 => ልደታ, 12 => ሚካኤል  	 |
| X | Orthodox year name 	| ማቴዎስ, ማርቆስ, ሉቃስ or ዮሐንስ  |
| X | Orthodox year name 	| ማቴዎስ, ማርቆስ, ሉቃስ or ዮሐንስ  |
| E | Era in Amharic     	| ዓ/ዓ or ዓ/ም				  |
| K | Year in geez numeber	| ፳፻፱						  |
| V | Day in geez numebr 	| ፪							  |				

<a name="constants"></a>
### Constants

We have already defined some handy constants to print as it's custom in Ethiopia :heart: .

```php
$date = new \Andegna\DateTime();

// ዓርብ፣ ግንቦት 04 ቀን 02:35:45 ውደቀት EAT 2009 ዓ/ም
echo $date->format(\Andegna\Constants::DATE_ETHIOPIAN);

$date->modify('+8 hours');

// ዓርብ፣ ግንቦት 04 ቀን (ዮሐንስ) 10:35:45 ረፋድ EAT 2009 (ማርቆስ) ዓ/ም
echo $date->format(\Andegna\Constants::DATE_ETHIOPIAN_ORTHODOX);

$date->modify('+1 year');

// ቅዳሜ፣ ግንቦት ፬ ቀን 10:35:45 ረፋድ EAT ፳፻፲ ዓ/ም
echo $date->format(\Andegna\Constants::DATE_GEEZ);

$date->modify('-3 years')->modify('+1 day');

// ረቡዕ፣ ግንቦት ፭ ቀን (አቦ) 10:35:45 ረፋድ EAT ፳፻፯ (ዮሐንስ) ዓ/ም
echo $date->format(\Andegna\Constants::DATE_GEEZ_ORTHODOX);
```

<a name="contributing"></a>
## Contributing

    Fork it
    Create your feature branch (git checkout -b my-new-feature)
    Commit your changes (git commit -am 'Add some feature')
    Push to the branch (git push origin my-new-feature)
    Create new Pull Request
