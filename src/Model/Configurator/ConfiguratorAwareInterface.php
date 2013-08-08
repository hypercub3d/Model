<?php

namespace Model\Configurator;

interface ConfiguratorAwareInterface
{
  public function getConfigurator();

  public function setConfigurator(callable $configurator);
}