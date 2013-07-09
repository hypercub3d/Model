<?php

namespace Model\Type;
use DateTime;
use DateTimeZone;

class Date extends VoAbstract
{
    public static function filter($value, array $config)
    {
        $config = array_merge([
            'defalut'  => 'now',
            'format'   => DATE_RFC822,
            'timezone' => null
        ], $config);

        $datetime = $value;

        if (!$value instanceof DateTime) {
            $datetime = new DateTime;

            if (is_numeric($value)) {
                $datetime->setTimestamp($value);
            } else {
                $datetime->modify($value ?: $config['default']);
            }
        }

        return $datetime->format($config['format']);
    }
}