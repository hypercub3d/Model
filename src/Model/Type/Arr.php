<?php

namespace Model\Type;
use Traversable;

class Arr
{
    public static function filter($value, array $config, $entity)
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value instanceof Traversable) {
            $value = iterator_to_array($value);
        }

        if (is_object($value)) {
            $value = (array) $value;
        }

        if (isset($config['item_type'])) {
            foreach ($value as &$v) {
                $v = $entity->type($config['item_type'])($v);
            }
        }

        return $value;
    }
}