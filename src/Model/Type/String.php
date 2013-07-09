<?php

namespace Model\Type;

class String
{
    public static function filter($value)
    {
        return (string) $value;
    }
}