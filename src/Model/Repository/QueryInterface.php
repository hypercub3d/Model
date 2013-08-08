<?php

namespace Model\Repository;

interface QueryInterface extends RepositoryInterface
{
  public function getCacheStrategy();

  public function setCacheStrategy(CacheStrategyInterface $strategy);

  public function getReturnValueFilter($method);

  public function setReturnValueFilter($method, callable $filter);
}