<?php

namespace Model\Entity;

interface EntityInterface extends AccessibleInterface
{
  public function __set($name, $value);

  public function __get($name);

  public function __isset($name);

  public function __unset($name);

  public function filter();

  public function value($name, callable $filter);

  public function one($name, $class);

  public function many($name, $class);
}