Andegna Calender
================

[![Build Status](https://travis-ci.org/andegna/calender.svg?branch=master)](https://travis-ci.org/andegna/calender)
[![StyleCI](https://styleci.io/repos/30183050/shield)](https://styleci.io/repos/30183050)
[![Total Downloads](https://poser.pugx.org/andegna/calender/d/total.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Stable Version](https://poser.pugx.org/andegna/calender/v/stable.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Unstable Version](https://poser.pugx.org/andegna/calender/v/unstable.svg)](https://packagist.org/packages/andegna/calender)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/calender/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![License](https://poser.pugx.org/andegna/calender/license.svg)](https://packagist.org/packages/andegna/calender)

If you ever want to convert **Ethiopian Date** to any other calender system 
like the Gregorian Calender this is the right package for you. 
And it also support Date Time formatting too. :

Basic Usage
-----------
### Create Ethiopian DateTime Object

- [Current Date Time2](#from-now)
- [From Gregorian Date Time](#from-gregorian)
- [From Ethiopian Day. Month, Year](#from-of)
- [From Timestamp](#from-timestamp)

#### Current Date Time
```php
$now1 = new EthiopianDateTime();
$now2 = DateTimeFactory::now();
```

#### From Gregorian Date Time
```php
$gregorian = new DateTime('next month');
$dateTime1 = new EthiopianDateTime($gregorian);
```

// From Ethiopian Day. Month, Year
$birthDay = DateTimeFactory::of(1986, 3, 21);
$millennium = DateTimeFactory::of(2000, 1, 1);
$ginbot20 = DateTimeFactory::of(1983, 9, 20);

// From the unix timestamp
$timestamp = time();

$now3 = DateTimeFactory::fromTimestamp($timestamp);
```
Contributing <p id="from-now" name="from-now"></p>
------------
    Fork it
    Create your feature branch (git checkout -b my-new-feature)
    Commit your changes (git commit -am 'Add some feature')
    Push to the branch (git push origin my-new-feature)
    Create new Pull Request
