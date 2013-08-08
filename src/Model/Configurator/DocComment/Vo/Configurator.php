<?php

namespace Model\Configurator\DocComment\Vo;
use Model\Configurator\DocComment\ConfiguratorAbstract;
use Model\Entity\EntityInterface;
use ReflectionClass;

class Configurator extends ConfiguratorAbstract
{
    public function __construct()
    {
        $this->addTagHandler('from', new Tag\From);
        $this->addTagHandler('many', new Tag\Many);
        $this->addTagHandler('one', new Tag\One);
        $this->addTagHandler('to', new Tag\To);
        $this->addTagHandler('validator', new Tag\Validator);
        $this->addTagHandler('vo', new Tag\Vo);
    }

    public function __invoke(EntityInterface $entity)
    {
        $class = new ReflectionClass($entity);

        foreach ($class->getProperties() as $property) {
            if ($property->isPublic()) {
                $this->configure($property, $entity);
                unset($entity->{$property->getName()});
            }
        }
    }
}