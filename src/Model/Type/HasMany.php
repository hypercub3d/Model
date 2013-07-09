<?php

namespace Model\Type;
use Model\Entity\Collection;

class HasMany
{
    public static function filter($value, array $config)
    {
        if (!$value instanceof Set) {
            $value = new Collection($config['class'], $value);
        }

        return $value;
    }
}