<?php

namespace Model\Vo;

class VoString extends VoAbstract
{
    public function init()
    {
        return '';
    }

    public function translate($value)
    {
        return (string) $value;
    }
}