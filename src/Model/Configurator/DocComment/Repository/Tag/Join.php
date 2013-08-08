<?php

namespace Model\Configurator\DocComment\Repository\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Repository\QueryInterface;
use ReflectionMethod;

class Join
{
  public function __invoke(DocTagInterface $tag, ReflectionMethod $method, QueryInterface $repository)
  {
    list($call, $field) = preg_split('/\s/', $tag->getValue());
    $repository->addJoin($method->getName(), $call, $field);
  }
}