<?php

namespace Model\Configurator\DocComment\Entity;
use Model\Configurator\DocComment\ConfiguratorAbstract;
use Model\Entity\EntityInterface;
use ReflectionClass;

class Configurator extends ConfiguratorAbstract
{
    public function __construct()
    {
        $this->addTagHandler('from', new Tag\From);
        $this->addTagHandler('to', new Tag\To);
        $this->addTagHandler('validator', new Tag\Validator);
    }

    public function __invoke(EntityInterface $entity)
    {
        $class = new ReflectionClass($entity);

        $this->configure($class, $entity);

        foreach ($class->getTraits() as $trait) {
            $this->configure($trait, $entity);
        }
    }
}