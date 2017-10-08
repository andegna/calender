<?php

namespace Andegna\Validator;

/**
 * Class ValidIntegerValidator.
 */
trait ValidIntegerValidator
{
    /**
     * @param array $integers a list of integers
     *
     * @return bool returns true if all the elements in the array are integer
     */
    public function isValidInteger(...$integers): bool
    {
        return array_reduce($integers, function ($carry, $integer) {
            return $carry && is_int($integer);
        }, true);
    }
}
