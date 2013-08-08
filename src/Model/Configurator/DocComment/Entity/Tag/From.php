<?php

namespace Model\Configurator\DocComment\Entity\Tag;
use Model\Configurator\DocComment\DocTagInterface;
use Model\Entity\EntityInterface;
use ReflectionClass;

class From
{
    public function __invoke(DocTagInterface $tag, ReflectionClass $class, EntityInterface $entity)
    {
        $parts = preg_split('/\s/', $tag->getValue());
        $entity->filter()->from($parts[0], new $parts[1]);
    }
}