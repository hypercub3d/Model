<?php

namespace Model\Entity;
use ArrayAccess;
use Countable;
use IteratorAggregate;
use Serializable;
use Model\Validator\ValidatableInterface;

interface AccessibleInterface extends ArrayAccess, Countable, IteratorAggregate, Serializable, ValidatableInterface
{
    public function fill($data, $mapper = null);

    public function toArray($mapper = null);
}