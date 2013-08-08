<?php

namespace Model\Vo;

class UniqueId
{
    public function __invoke($value)
    {
        return $value ?: uniqid();
    }
}