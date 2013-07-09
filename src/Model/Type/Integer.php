<?php

namespace Model\Type;

class Integer
{
    public static function filter($value)
    {
        return (int) $value;
    }
}