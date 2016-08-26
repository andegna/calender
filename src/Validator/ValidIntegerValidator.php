<?php

namespace Andegna\Validator;

trait ValidIntegerValidator
{
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
