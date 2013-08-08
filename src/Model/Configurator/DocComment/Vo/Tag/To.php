<?php

namespace Model\Configurator\DocComment\Vo\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Entity\EntityInterface;
use ReflectionProperty;

class To
{
  public function __invoke(DocTagInterface $tag, ReflectionProperty $property, EntityInterface $entity)
  {
    $parts = preg_split('/\s/', $tag->getValue());
    $entity->filter()->__get($property->getName())->to($parts[0], new $parts[1]);
  }
}