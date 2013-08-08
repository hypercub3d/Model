<?php

namespace Model\Cache;
use Model\Exception;

class Chain implements CacheInterface
{
    private $drivers = array();

    public function __construct(array $drivers = [])
    {
        foreach ($drivers as $driver) {
            $this->add($driver);
        }
    }

    public function add(CacheInterface $driver)
    {
        $this->drivers[] = $driver;
        return $this;
    }

    public function set($key, $value, $lifetime = null)
    {
        foreach ($this->drivers as $cache) {
            $cache->set($key, $value, $lifetime);
        }
        return $this;
    }

    public function get($key)
    {
        foreach ($this->drivers as $cache) {
            if ($value = $cache->get($key)) {
                return $value;
            }
        }
    }

    public function has($key)
    {
        foreach ($this->drivers as $cache) {
            if ($cache->has($key)) {
                return true;
            }
        }
        return false;
    }

    public function remove($key)
    {
        foreach ($this->drivers as $cache) {
            $cache->remove($key);
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
}