<?php

namespace Model\Configurator;

trait ConfiguratorAware
{
  private $configurator;

  public function getConfigurator()
  {
    return $this->configurator;
  }

  public function setConfigurator(callable $configurator)
  {
    $this->configurator = $configurator;
    return $this;
  }
}