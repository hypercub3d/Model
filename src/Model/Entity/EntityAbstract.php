<?php

namespace Model\Entity;
use InvalidArgumentException;
use Model\Configurator\DocComment\Entity\Configurator as EntityConfigurator;
use Model\Configurator\DocComment\Vo\Configurator as VoConfigurator;
use Model\Validator\Assertable;
use Model\Validator\AssertableInterface;

abstract class EntityAbstract implements EntityInterface
{
    use Assertable;

    private $filters;

    private $data = [];

    private $values = [];

    private $hasOne = [];

    private $hasMany = [];

    public function __construct($data = [], $filterToUse = null)
    {
        $this->filters = new Filters;

        $this->configure();
        $this->init();
        $this->from($data, $filterToUse);
    }

    public function __set($name, $value)
    {
        if (isset($this->values[$name])) {
            $this->data[$name] = $this->values[$name]($value);
        }
    }

    public function __get($name)
    {
        if (isset($this->values[$name])) {
            return $this->data[$name];
        }
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

    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function offsetUnset($offset)
    {
        return $this->__unset($offset);
    }

    public function configure()
    {
        $conf = new EntityConfigurator;
        $conf->__invoke($this);

        $conf = new VoConfigurator;
        $conf->__invoke($this);
    }

    public function init()
    {

    }

    public function clear()
    {
        $this->data = [];
        return $this;
    }

    public function filter()
    {
        return $this->filters;
    }

    public function value($name, callable $value)
    {
        $this->values[$name] = $value;
        return $this;
    }

    public function one($name, $class)
    {
        $this->data[$name] = new $class;
        return $this;
    }

    public function many($name, $class)
    {
        $this->data[$name] = new Collection($class);
        return $this;
    }

    public function from($data, $filter = null)
    {
        $data = $this->makeArrayFromAnything($data);
        $data = $this->filters->filterFrom($filter, $data);

        foreach ($data as $name => $value) {
            if (isset($this->values[$name])) {
                $this->data[$name] = $this->values[$name](
                    $this->filters->__get($name)->filterFrom($filter, $value)
                );
            } elseif (isset($this->data[$name]) && $this->data[$name] instanceof AccessibleInterface) {
                $this->data[$name]->from($value, $filter);
            }
        }

        return $this;
    }

    public function to($filter = null)
    {
        $data = $this->data;

        foreach ($data as $name => &$value) {
            if ($value instanceof AccessibleInterface) {
                $value = $value->to($filter);
            } else {
                $value = $this->filters->__get($name)->filterTo($filter, $value);
            }
        }

        return $this->filters->filterTo($filter, $data);
    }

    public function validate()
    {
        $messages = [];

        foreach ($this->values as $name => $vo) {
            if ($voMessages = $vo->validate($this->data[$name])) {
                $messages = array_merge($messages, $voMessages);
            }
        }

        foreach ($this->validators as $message => $validator) {
            if ($validator($this) === false) {
                $messages[] = $this->validatorMessages[$message];
            }
        }

        foreach ($messages as &$message) {
            foreach ($this->data as $name => $value) {
                if (is_scalar($value)) {
                    $message = str_replace(':' . $name, $value, $message);
                }
            }
        }

        return $messages;
    }

    public function count()
    {
       return count($this->data);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function serialize()
    {
        return $this->to();
    }

    public function unserialize($data)
    {
        $this->configure();
        $this->from($data);
    }

    private function makeArrayFromAnything($data)
    {
        if (is_array($data) || $data instanceof \Traversable) {
            foreach ($data as $k => &$v) {
                if (is_array($v) || is_object($v)) {
                    $v = $this->makeArrayFromAnything($v);
                }
            }

            return $data;
        }

        return [];
    }

    public static function create($data = [], $mapper = null)
    {
        $class = get_called_class();
        return new $class($data, $mapper);
    }

    public static function collection($data = [], $mapper = null)
    {
        return new Collection(get_called_class(), $data, $mapper);
    }

    public static function fix(callable $gen)
    {
        $class = get_called_class();

        return function ($min = 0, $max = 0) use ($gen, $class) {
            if (!$min) {
                return $class::create($gen());
            }

            if (!$max) {
                $max = $min;
            } else {
                $max = rand($min, $max);
            }

            $collection = $class::collection();

            for ($i = 0; $i < $max; $i++) {
                $collection->append($class::create($gen()));
            }

            return $collection;
        };
    }
}