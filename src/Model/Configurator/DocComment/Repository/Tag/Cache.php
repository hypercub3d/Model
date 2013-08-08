<?php

namespace Model\Configurator\DocComment\Repository\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Repository\QueryInterface;
use ReflectionMethod;

class Cache
{
  public function __invoke(DocTagInterface $tag, ReflectionMethod $method, QueryInterface $repository)
  {
    list($driver, $lifetime) = preg_split('/\s/', $tag->getValue());
    $repository->setCacheDriverFor($method->getName(), $driver, $lifetime);
  }
}