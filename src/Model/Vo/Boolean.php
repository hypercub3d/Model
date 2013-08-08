<?php

namespace Model\Vo;

class Boolean
{
    public function __invoke($value)
    {
        $lower = strtolower($value);

        if ($lower === 'true') {
            return true;
        }

        if ($lower === 'false' || $lower === 'null') {
            return false;
        }

        return (bool) $value;
    }
}