<?php

namespace Andegna\Validator;

/**
 * Class ValidIntegerValidator.
 */
trait ValidIntegerValidator
{
    /**
     * @internal ... args of values
     *
     * @return bool
     */
    public function isValidInteger()
    {
        $args = func_get_args();

        foreach ($args as $arg) {
            if (!is_int($arg)) {
                return false;
            }
        }

        return true;
    }
}
