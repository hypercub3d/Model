<?php

namespace Model\Vo;

class Float
{
    public function __invoke($value)
    {
        return (float) $value;
    }
}