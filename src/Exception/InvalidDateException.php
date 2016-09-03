<?php

namespace Andegna\Exception;

use Exception;

class InvalidDateException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid date was given');
    }
}
