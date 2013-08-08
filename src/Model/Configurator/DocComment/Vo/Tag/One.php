<?php

namespace Model\Configurator\DocComment\Vo\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Entity\EntityInterface;
use ReflectionProperty;

class One
{
  public function __invoke(DocTagInterface $tag, ReflectionProperty $property, EntityInterface $entity)
  {
    $entity->one($property->getName(), $tag->getValue());
  }
}