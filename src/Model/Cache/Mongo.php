<?php

namespace Model\Cache;

class Mongo implements CacheInterface
{
    private $config = [
        'db'         => 'cache',
        'collection' => 'cache',
        'dsn'        => null,
        'options'    => []
    ];

    private $mongo;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, $config);

        $mongo   = new \Mongo($this->config['dsn'], $this->config['options']);
        $mongodb = $mongo->selectDB($this->config['db']);

        $this->collection = $mongodb->selectCollection($this->config['collection']);
        $this->collection->ensureIndex([
            '_id'     => 1,
            'expires' => 1
        ], [
            'background' => true
        ]);
    }

    public function set($key, $value, $lifetime = null)
    {
        if ($lifetime) {
            $lifetime = time() + $lifetime;
        }

        $this->collection->save([
            '_id'     => $key,
            'value'   => serialize($value),
            'expires' => $lifetime
        ]);

        return $this;
    }

    public function get($key)
    {
        $value = $this->collection->findOne(['_id' => $key, 'expires' => ['$gte' => time()]]);

        if ($value) {
            $value = $value['value'];
            $value = unserialize($value);
        }

        return $value ?: false;
    }

    public function has($key)
    {
        return $this->get($key) !== false;
    }

    public function remove($key)
    {
        $this->collection->remove(['_id' => $key]);
        return $this;
    }

    public function clear()
    {
        $this->collection->remove();
        return $this;
    }
}