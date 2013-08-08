<?php

namespace Model\Vo;

class Integer
{
    public function __invoke($value)
    {
        return (int) $value;
    }
}