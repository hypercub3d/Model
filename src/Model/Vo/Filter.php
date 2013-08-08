<?php

namespace Model\Vo;

class Filter
{
    private $cb;

    public function __construct(callable $cb)
    {
        $this->cb = $cb;
    }

    public function __invoke($value)
    {
        $cb = $this->cb;
        return $cb($value);
    }
}