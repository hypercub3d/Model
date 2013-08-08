<?php

namespace Model\Cache;

class Php implements CacheInterface
{
    private $cache = array();

    public function set($key, $value, $lifetime = null)
    {
        $this->cache[$key] = $value;
        return $this;
    }

    public function get($key)
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        return null;
    }

    public function has($key)
    {
        return isset($this->cache[$key]);
    }

    public function remove($key)
    {
        if (isset($this->cache[$key])) {
            unset($this->cache[$key]);
        }
        return $this;
    }

    public function clear()
    {
        $this->cache = [];
        return $this;
    }
}