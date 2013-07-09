<?php

namespace Model\Type;
use Model\Entity\Set;

class HasMany
{
    public static function filter($value, array $config)
    {
        if (!$value instanceof Set) {
            $value = new Set($config['class'], $value);
        }

        return $value;
    }
}