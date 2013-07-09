<?php

namespace Model\Entity;
use ArrayIterator;
use ReflectionClass;
use ReflectionProperty;
use UnexpectedValueException;

abstract class EntityAbstract implements AccessibleInterface
{
    private $data = [];

    private static $class;

    private static $definition = [];

    private static $mappers = [];

    public function __construct($data = [], $mapper = null)
    {
        $this->applyConfiguration();
        $this->fill($data, $mapper);
    }

    public function __set($name, $value)
    {
        if ($closure = self::$definition[self::$class][$name]['type']) {
            $this->data[$name] = $closure($this, $value);
        }
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }

    public function offsetSet($name, $value)
    {
        $this->__set($name, $value);
    }

    public function offsetGet($name)
    {
        return $this->__get($name);
    }

    public function offsetExists($name)
    {
        return $this->__isset($name);
    }

    public function offsetUnset($name)
    {
        $this->__unset($name);
    }

    public function count()
    {
        return count($this->data);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    public function fill($data, $mapper = null)
    {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $name => $value) {
                $this->__set($name, $value);
            }
        }

        return $this;
    }

    public function toArray($mapper = null)
    {
        $data = [];

        foreach ($this->data as $name => $value) {
            if ($value instanceof self || $value instanceof Set) {
                $data[$name] = $value->toArray($mapper);
            } else {
                $data[$name] = $value;
            }
        }

        return $data;
    }

    public function assert()
    {

    }

    public function validate()
    {

    }

    public function serialize()
    {

    }

    public function unserialize($serialized)
    {

    }

    public function reset()
    {
        foreach ($this->definition as $name => $definition) {
            if (isset($definition['default'])) {
                $this->__set($name, $definition['default']);
            } else {
                $this->__unset($name);
            }
        }

        $this->emit('reset', $this);
    }

    public function types()
    {
        return [
            'array'      => 'Model\Type\Arr::filter',
            'boolean'    => 'Model\Type\Boolean::filter',
            'date'       => 'Model\Type\Date::filter',
            'enum'       => 'Model\Type\Enum::filter',
            'enum_set'   => 'Model\Type\EnumSet::filter',
            'float'      => 'Model\Type\Float::filter',
            'guid'       => 'Model\Type\Guid::filter',
            'has_many'   => 'Model\Type\HasMany::filter',
            'has_one'    => 'Model\Type\HasOne::filter',
            'integer'    => 'Model\Type\Integer::filter',
            'money'      => 'Model\Type\Money::filter',
            'string'     => 'Model\Type\String::filter'
        ];
    }

    private function applyConfiguration()
    {
        self::$class = get_class($this);
        $this->sniffDefinition();
        $this->removePropertiesInDefinition();
        $this->applyDefaultsFromDefinition();
    }

    private function sniffDefinition()
    {
        if (isset(self::$definition[self::$class])) {
            return;
        }

        self::$mappers[self::$class] = [];
        self::$definition[self::$class] = [];

        $reflector = new ReflectionClass($this);

        foreach ($reflector->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            $config = $this->$name;

            if (!is_array($config)) {
                throw new UnexpectedValueException(sprintf('The definition for "%s" must be an array.', $name));
            }

            if (!isset($config['type'])) {
                throw new UnexpectedValueException(sprintf('The definition for "%s" must specify a "type".', $name));
            }

            self::$definition[self::$class][$name]['type'] = function($entity, $newValue) use ($config) {
                $types = $entity->types();

                if (!isset($types[$config['type']])) {
                    throw new UnexpectedValueException(sprintf('The definition for "%s" requires a handler for the type "%s".', get_class($entity), $config['type']));
                }

                return call_user_func($types[$config['type']], $newValue, $config, $entity);
            };
        }
    }

    private function removePropertiesInDefinition()
    {
        foreach (self::$definition[self::$class] as $name => $definition) {
            unset($this->$name);
        }
    }

    private function applyDefaultsFromDefinition()
    {
        foreach (self::$definition[self::$class] as $name => $definition) {
            $this->__set($name, $definition['default']);
        }
    }
}