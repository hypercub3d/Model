<?php

namespace Model\Repository;
use InvalidArgumentException;
use Model\Configurator\DocComment\Repository\Configurator;
use Model\Configurator\ConfiguratorAware;
use Model\Configurator\ConfiguratorAwareInterface;

class Manager implements ConfiguratorAwareInterface, ManagerInterface
{
  use ConfiguratorAware;

  private $cached = [];

  private $factories = [];

  public function __construct()
  {
    $this->configurator = new Configurator;
  }

  public function __invoke($name)
  {
    if (isset($this->cached[$name])) {
      return $this->cached[$name];
    }

    foreach ($this->factories as $pattern => $factory) {
      if (preg_match('/' . $pattern . '/i', $name, $matches)) {
        $conf = $this->configurator;
        $repo = $factory($matches);

        $conf($repo);

        return $this->cached[$name] = $repo;
      }
    }

    throw new InvalidArgumentException(sprintf('The repository "%s" does not exist.', $name));
  }

  public function register($pattern, callable $factory)
  {
    $this->factories[$pattern] = $factory;
    return $this;
  }
}