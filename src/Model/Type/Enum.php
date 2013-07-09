<?php

namespace Model\Type;
use UnexpectedValueException;

class Enum
{
    public static function filter($value, array $config)
    {
        if (!isset($config['values'])) {
            throw new UnexpectedValueException('The type "%s" expects a "values" array.', $config['type']);
        }

        if (in_array($value, $config['values'])) {
            return $value;
        }
    }
}