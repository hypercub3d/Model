<?php

namespace Model\Type;

class UniqueId
{
    public static function filter($value)
    {
        if ($value) {
            return $value;
        }

        $config = array_merge([
            'prefix'       => '',
            'more_entropy' => false
        ], $config);

        return uniqid($config['prefix'], $config['more_entropy']);
    }
}