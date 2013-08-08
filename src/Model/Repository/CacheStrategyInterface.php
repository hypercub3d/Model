<?php

namespace Model\Repository;

interface CacheStrategyInterface
{
  public function getDriver($name);

  public function setDriver($name, CacheInterface $driver);

  public function getMethodDriver($method);

  public function setMethodDriver($method, $name, $lifetime = null);

  public function getCache($method, array $args);

  public function setCache($method, array $args, $value);

  public function clearCache();
}