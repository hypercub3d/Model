<?php

namespace Model\Repository;
use LogicException;
use ReflectionMethod;

abstract class QueryAbstract implements QueryInterface
{
  private $cacheStrategy;

  private $returnValueFilters = [];

  public function __call($name, array $args = [])
  {
    $this->throwIfMethodNotExists($name);
    $this->throwIfMethodNotProtected($name);

    if ($this->cacheStrategy && $this->cacheStrategy->has($name, $args)) {
      return $this->cacheStrategy->get($name, $args);
    }

    $value = call_user_func_array([$this, $name], $args);
    $value = $this->filterReturnValue($name, $value);

    if ($this->cacheStrategy) {
      $this->cacheStrategy->set($name, $args, $value);
    }

    return $value;
  }

  public function call($name)
  {
    $args = func_get_args();
    array_shift($args);
    return $this->__call($name, $args);
  }

  public function getCacheStrategy()
  {
    return $this->cacheStrategy;
  }

  public function setCacheStrategy(CacheStrategyInterface $cacheStrategy)
  {
    $this->cacheStrategy = $cacheStrategy;
    return $this;
  }

  public function getReturnValueFilter($method)
  {
    if (isset($this->returnValueFilters[$method])) {
      return $this->returnValueFilters[$method];
    }
  }

  public function setReturnValueFilter($method, callable $filter)
  {
    $this->returnValueFilters[$method] = $filter;
    return $this;
  }

  private function filterReturnValue($method, $value)
  {
    if (isset($this->returnValueFilters[$method])) {
      $value = $this->returnValueFilters[$method]($value);
    }

    return $value;
  }

  private function throwIfMethodNotExists($method)
  {
    if (!method_exists($this, $method)) {
      $class = get_class($this);
      $trace = debug_backtrace();

      foreach ($trace as $k => $call) {
        if ($call['class'] === $class && $call['function'] === $method) {
          $origin = $trace[$k + 1];
          $origin['file'] = $call['file'];
          $origin['line'] = $call['line'];
          break;
        }
      }

      throw new LogicException(sprintf(
        'The method "%s" does not exist in "%s" as called from "%s%s%s() in "%s" on line "%s".',
        $method,
        $class,
        $origin['class'],
        $origin['type'],
        $origin['function'],
        $origin['file'],
        $origin['line']
      ));
    }
  }

  private function throwIfMethodNotProtected($method)
  {
    $reflector = new ReflectionMethod($this, $method);

    if (!$reflector->isProtected()) {
      throw new LogicException(sprintf(
        'You must define "%s::%s()" as protected.',
        get_class($this),
        $method
      ));
    }
  }
}