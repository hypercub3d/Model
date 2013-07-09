<?php

namespace Model\Type;
use UnexpectedValueException;

class EnumSet
{
    public static function filter($value, array $config)
    {
        if (!isset($config['values'])) {
            throw new UnexpectedValueException('The type "%s" expects a "values" array.', $config['type']);
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        $add = [];

        foreach ($value as $k => $v) {
            if (in_array($v, $config['values'])) {
                $add[$k] = $v;
            }
        }

        return $add;
    }
}