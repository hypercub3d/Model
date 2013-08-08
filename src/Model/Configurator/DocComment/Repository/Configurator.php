<?php

namespace Model\Configurator\DocComment\Repository;
use Model\Configurator\DocComment\ConfiguratorAbstract;
use Model\Repository\RepositoryInterface;
use ReflectionClass;

class Configurator extends ConfiguratorAbstract
{
    public function __construct()
    {
        $this->addTagHandler('cache', new Tag\Cache);
        $this->addTagHandler('join', new Tag\Join);
        $this->addTagHandler('many', new Tag\Many);
        $this->addTagHandler('one', new Tag\One);
    }

    public function __invoke(RepositoryInterface $repository)
    {
        $reflector = new ReflectionClass($repository);

        foreach ($reflector->getMethods() as $method) {
            $this->configure($method, $repository);
        }
    }
}