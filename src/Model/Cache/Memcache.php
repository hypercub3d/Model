<?php

namespace Model\Cache;
use Memcache;

/**
 * The Memcache driver.
 * 
 * @category Cache
 * @package  Model
 * @author   Trey Shugart <treshugart@gmail.com>
 * @license  Copyright (c) 2011 Trey Shugart http://europaphp.org/license
 */
class Memcache implements CacheInterface
{
    /**
     * The default Memcache configuration.
     * 
     * @var array
     */
    private $config = array(
        'servers' => array(
            array(
                'host' => 'localhost',
                'port' => 11211
            )
        ),
        'lifetime' => 0
    );
    
    /**
     * The memcache instance to use.
     * 
     * @var Memcache
     */
    private $memcache;
    
    /**
     * Constructs a new memcache cache driver and sets its configuration.
     * 
     * @param array $config The Memcache configuration.
     * 
     * @return Memcache
     */
    public function __construct(array $config = array())
    {    
        $this->config   = array_merge($this->config, $config);
        $this->memcache = new Memcache;
        
        foreach ($this->config['servers'] as $server) {
            $this->memcache->addServer($server['host'], $server['port']);
        }
    }
    
    /**
     * Sets an item in the cache.
     * 
     * @param string $key      The cache key.
     * @param mixed  $value    The cached value.
     * @param mixed  $lifetime The max lifetime of the item in the cache.
     * 
     * @return Memcache
     */
    public function set($key, $value, $lifetime = null)
    {
        $lifetime = is_null($lifetime) ? $this->config['lifetime'] : $lifetime;
        
        $this->memcache->add($key, $value, $lifetime);
        
        return $this;
    }
    
    /**
     * Returns an item from the cache.
     * 
     * @param string $key The cache key.
     * 
     * @return mixed
     */
    public function get($key)
    {
        return $this->memcache->get($key);
    }
    
    /**
     * Checks to see if the specified cache item exists.
     * 
     * @param string $key The key to check for.
     * 
     * @return bool
     */
    public function exists($key)
    {
        return $this->memcache->get($key) !== false;
    }
    
    /**
     * Removes the item with the specified key.
     * 
     * @param string $key The key of the item to remove.
     * 
     * @return Memcache
     */
    public function remove($key)
    {
        $this->memcache->delete($key);
        return $this;
    }
    
    /**
     * Clears the whole cache.
     * 
     * @return Memcache
     */
    public function clear()
    {
        $this->memcache->flush();
        return $this;
    }
}