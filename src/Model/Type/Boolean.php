<?php

namespace Model\Type;

class Boolean
{
    public static function filter($value)
    {
        $lower = strtolower($value);

        if ($lower === 'true') {
            return true;
        }

        if ($lower === 'false' || $lower === 'null') {
            return false;
        }

        return (bool) $value;
    }
}