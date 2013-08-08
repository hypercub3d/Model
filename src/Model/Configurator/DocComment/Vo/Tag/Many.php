<?php

namespace Model\Configurator\DocComment\Vo\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Entity\EntityInterface;
use ReflectionProperty;

class Many
{
  public function __invoke(DocTagInterface $tag, ReflectionProperty $property, EntityInterface $entity)
  {
    $entity->many($property->getName(), $tag->getValue());
  }
}