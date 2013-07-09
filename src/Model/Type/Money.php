<?php

namespace Model\Type;

class Money
{
    public static function filter($value, array $config)
    {
        $config = array_merge([
            'precision' => 2
        ], $config);

        return (float) number_format($value, $config['precision']);
    }
}