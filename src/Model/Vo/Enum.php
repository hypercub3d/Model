<?php

namespace Model\Vo;

class Enum
{
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function __invoke($value)
    {
        if (in_array($value, $this->values)) {
            return $value;
        }
    }
}