<?php

namespace Model\Configurator\DocComment\Repository\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Entity\Set;
use Model\Repository\QueryInterface;
use ReflectionMethod;

class One
{
  public function __invoke(DocTagInterface $tag, ReflectionMethod $method, QueryInterface $repository)
  {
    $parts = preg_split('/\s/', $tag->getValue());
    $class = $parts[1];
    $filter = isset($parts[1]) ? $parts[1] : null;

    $repository->setReturnValueFilter($method->getName(), function($value) use ($class, $filter) {
      return $value ? new $entity($value, $filter) : null;
    });
  }
}