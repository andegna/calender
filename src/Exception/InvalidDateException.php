<?php

namespace Andegna\Exception;

use Exception;

/**
 * Invalid Ethiopian Date Exception.
 */
class InvalidDateException extends Exception
{
    /**
     * InvalidDateException constructor.
     *
     * @param $message string
     */
    public function __construct(string $message = 'Invalid date was given')
    {
        parent::__construct($message);
    }
}
