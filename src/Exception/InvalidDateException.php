<?php

namespace Andegna\Exception;

use Exception;

/**
 * Invalid Date Exception.
 */
class InvalidDateException extends Exception
{
    /**
     * InvalidDateException constructor.
     *
     * @param $message string
     */
    public function __construct($message = 'Invalid date was given')
    {
        parent::__construct($message);
    }
}
