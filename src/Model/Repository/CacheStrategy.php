<?php

namespace Model\Repository;
use Model\Cache\CacheInterface;

class CacheStrategy implements CacheStrategyInterface
{
  private $guid;

  private $drivers = [];

  private $methods = [];

  private $lifetimes = [];

  public function __construct()
  {
    $this->guid = uniqid();
  }

  public function get($method, array $args)
  {
    if ($driver = $this->getMethodDriver($method)) {
      return $driver->get($this->generateKey($method, $args));
    }
  }

  public function set($method, array $args, $value)
  {
    if ($driver = $this->getMethodDriver($method)) {
      return $driver->set(
        $this->generateKey($method, $args),
        $value,
        isset($this->lifetimes[$method]) ? $this->lifetimes[$method] : null
      );
    }

    return $this;
  }

  public function clear()
  {
    foreach ($this->drivers as $driver) {
      $driver->clear();
    }

    return $this;
  }

  public function getDriver($name)
  {
    if (isset($this->drivers[$name])) {
      return $this->drivers[$name];
    }
  }

  public function setDriver($name, CacheInterface $driver)
  {
    $this->drivers[$name] = $driver;
    return $this;
  }

  public function getMethodDriver($method)
  {
    if (isset($this->methods[$method])) {
      return $this->drivers[$this->methods[$method]];
    }
  }

  public function setMethodDriver($method, $name, $lifetime = null)
  {
    $this->methods[$method] = $name;
    $this->lifetimes[$method] = $lifetime;
    return $this;
  }

  private function generateKey($method, array $args)
  {
    return md5($guid . $method . serialize($args));
  }
}