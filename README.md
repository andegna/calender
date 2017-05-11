# Andegna Calender

[![Build Status](https://travis-ci.org/andegna/calender.svg?branch=master)](https://travis-ci.org/andegna/calender)
[![StyleCI](https://styleci.io/repos/30183050/shield)](https://styleci.io/repos/30183050)
[![Total Downloads](https://poser.pugx.org/andegna/calender/d/total.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Stable Version](https://poser.pugx.org/andegna/calender/v/stable.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Unstable Version](https://poser.pugx.org/andegna/calender/v/unstable.svg)](https://packagist.org/packages/andegna/calender)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/calender/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![License](https://poser.pugx.org/andegna/calender/license.svg)](https://packagist.org/packages/andegna/calender)

> If you ever want to convert **Ethiopian Calender** to any other calender system
> (like the Gregorian Calender) this is the right package for you.
> > And by the way it also support Amharic date formatting and much much more.

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
## Basic Usage

```php
$gregorian = new DateTime('now');

$ethipic = new Andegna\DateTime($gregorian); // now

echo $ethipic->format(Andegna\Constants::DATE_GEEZ_ORTHODOX);
// Will output something like
// እሑድ፣ ግንቦት ፮ ቀን (ኢያሱስ) 00:00:00 እኩለ፡ሌሊት EAT ፳፻፱ (ማርቆስ) ዓ/ም
```

<a name="requirement"></a>
## Requirement

Andegna Calender requires PHP `>= 5.6`

<a name="installation"></a>
## Installation

```bash
composer require andegna/calender
```

<a name="contributing"></a>
## Contributing

    Fork it
    Create your feature branch (git checkout -b my-new-feature)
    Commit your changes (git commit -am 'Add some feature')
    Push to the branch (git push origin my-new-feature)
    Create new Pull Request
