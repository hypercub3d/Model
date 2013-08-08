<?php

namespace Model\Repository;

interface ManagerInterface
{
  public function __invoke($name);

  public function register($name, callable $repository);
}