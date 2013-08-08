<?php

namespace Model\Cache;
use Memcache;

class Memcache implements CacheInterface
{
    private $config = [
        'servers' => [[
            'host' => 'localhost',
            'port' => 11211
        ]]
    ];

    private $memcache;

    public function __construct(array $config = [])
    {
        $this->config   = array_merge($this->config, $config);
        $this->memcache = new Memcache;

        foreach ($this->config['servers'] as $server) {
            $this->memcache->addServer($server['host'], $server['port']);
        }
    }

    public function set($key, $value, $lifetime = null)
    {
        $this->memcache->add($key, $value, $lifetime);
        return $this;
    }

    public function get($key)
    {
        return $this->memcache->get($key);
    }

    public function has($key)
    {
        return $this->memcache->get($key) !== false;
    }

    public function remove($key)
    {
        $this->memcache->delete($key);
        return $this;
    }

    public function clear()
    {
        $this->memcache->flush();
        return $this;
    }
}