<?php

namespace Model\Entity;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Model\Validator\AssertableInterface;
use Serializable;

interface AccessibleInterface extends ArrayAccess, AssertableInterface, Countable, IteratorAggregate, Serializable
{
  public function clear();

  public function from($data, $filter = null);

  public function to($filter = null);
}