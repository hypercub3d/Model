<?php

namespace Model\Cache;

interface CacheInterface
{
    public function set($key, $value, $lifetime = null);

    public function get($key);

    public function has($key);

    public function remove($key);

    public function clear();
}