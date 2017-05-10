Andegna Calender
================

[![Build Status](https://travis-ci.org/andegna/calender.svg?branch=master)](https://travis-ci.org/andegna/calender)
[![StyleCI](https://styleci.io/repos/30183050/shield)](https://styleci.io/repos/30183050)
[![Total Downloads](https://poser.pugx.org/andegna/calender/d/total.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Stable Version](https://poser.pugx.org/andegna/calender/v/stable.svg)](https://packagist.org/packages/andegna/calender)
[![Latest Unstable Version](https://poser.pugx.org/andegna/calender/v/unstable.svg)](https://packagist.org/packages/andegna/calender)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/calender/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/calender/?branch=master)
[![License](https://poser.pugx.org/andegna/calender/license.svg)](https://packagist.org/packages/andegna/calender)

If you ever want to convert **Ethiopian Calender** to any other calender system
(like the Gregorian Calender) this is the right package for you. 

And by the way it also support Amharic date formatting and much much more.

Basic Usage
-----------

```php
$gregorian = new DateTime('next sunday');

$ethipic = new Andegna\DateTime($gregorian); // now

echo $ethipic->format(Andegna\Constants::DATE_GEEZ_ORTHODOX);
// Will output something like
// እሑድ፣ ግንቦት ፮ ቀን (ኢያሱስ) 00:00:00 እኩለ፡ሌሊት EAT ፳፻፱ (ማርቆስ) ዓ/ም
```

Installation
------------


Conversion
----------


Manipulation
------------


Formatting
----------


Holidays
--------


Contributing
------------
    Fork it
    Create your feature branch (git checkout -b my-new-feature)
    Commit your changes (git commit -am 'Add some feature')
    Push to the branch (git push origin my-new-feature)
    Create new Pull Request
