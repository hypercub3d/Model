<?php

namespace Model\Vo;

class Money
{
    public function __invoke($value)
    {
        return (float) number_format($value, 2);
    }
}