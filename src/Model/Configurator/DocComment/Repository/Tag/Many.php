<?php

namespace Model\Configurator\DocComment\Repository\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Entity\Collection;
use Model\Repository\QueryInterface;
use ReflectionMethod;

class Many
{
  public function __invoke(DocTagInterface $tag, ReflectionMethod $method, QueryInterface $repository)
  {
    $parts = preg_split('/\s/', $tag->getValue());
    $class = $parts[1];
    $filter = isset($parts[1]) ? $parts[1] : null;

    $repository->setReturnValueFilter($method->getName(), function($value) use ($class, $filter) {
      return new Collection($class, $value, $filter);
    });
  }
}