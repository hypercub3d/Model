<?php

namespace Model\Vo;

class String
{
  public function __invoke($value)
  {
    return (string) $value;
  }
}