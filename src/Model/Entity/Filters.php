<?php

namespace Model\Entity;
use Model\Filter;

class Filters
{
  private $fromFilters;

  private $toFilters;

  private $values = [];

  public function __construct()
  {
    $this->fromFilters = new Filter\Collection;
    $this->toFilters = new Filter\Collection;
  }

  public function __get($name)
  {
    if (!isset($this->values[$name])) {
      $this->values[$name] = new self;
    }

    return $this->values[$name];
  }

  public function from($name, callable $filter)
  {
    $this->fromFilters->add($name, $filter);
    return $this;
  }

  public function to($name, callable $filter)
  {
    $this->toFilters->add($name, $filter);
    return $this;
  }

  public function filterFrom($name, $data)
  {
    foreach ($this->fromFilters->get($name) as $filter) {
      $data = $filter($data);
    }

    return $data;
  }

  public function filterTo($name, $data)
  {
    foreach ($this->toFilters->get($name) as $filter) {
      $data = $filter($data);
    }

    return $data;
  }
}