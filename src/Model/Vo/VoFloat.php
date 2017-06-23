<?php

namespace Model\Vo;

class VoFloat extends VoAbstract
{
    public function init()
    {
        return 0;
    }

    public function translate($value)
    {
        return (float) $value;
    }
}