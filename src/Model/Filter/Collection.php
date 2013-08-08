<?php

namespace Model\Filter;

class Collection
{
  private $filters = [];

  public function get($name)
  {
    $parts = explode('.', $name);
    $joins = [];
    $filters = [];

    foreach ($parts as $part) {
      $joins[] = $part;
      $joined = implode('.', $joins);

      if (isset($this->filters[$joined])) {
        foreach ($this->filters[$joined] as $filter) {
          $filters[] = $filter;
        }
      }
    }

    return $filters;
  }

  public function add($name, callable $filter)
  {
    if (!isset($this->filters[$name])) {
      $this->filters[$name] = [];
    }

    $this->filters[$name][] = $filter;

    return $this;
  }
}