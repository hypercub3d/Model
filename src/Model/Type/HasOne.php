<?php

namespace Model\Type;

class HasOne
{
    public static function filter($value, array $config)
    {
        if (!$value instanceof $config['class']) {
            $value = new $config['class']($value);
        }

        return $value;
    }
}