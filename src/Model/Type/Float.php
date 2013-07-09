<?php

namespace Model\Type;

class Float
{
    public static function filter($value)
    {
        return (float) $value;
    }
}