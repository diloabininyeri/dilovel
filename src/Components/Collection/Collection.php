<?php
namespace App\Components\Collection;

use App\Interfaces\ArrayAble;
use App\Interfaces\ToJson;
use App\Macro\ModelMacro;
use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use JsonException;
use JsonSerializable;
use Traversable;

/**
 * Class Collection
 * @noinspection PhpUnused
 */
class Collection implements ArrayAccess, IteratorAggregate, JsonSerializable, Countable, ArrayAble, ToJson
{
    /**
     * @var array $collection
     */
    private array  $collection;

    public function __construct(array $collection)
    {
        $this->collection=$collection;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->collection[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (empty($offset)) {
            return $this->collection[] = $value;
        }

        return $this->collection[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->collection[$offset]);
    }



    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return serialize($this->collection);
    }

    /**
     * @inheritDoc
     */
    public function count():int
    {
        return count($this->collection);
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return $this->collection;
    }


    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function first()
    {
        return $this->collection[0];
    }

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->collection);
    }

    /**
     * @noinspection MagicMethodsValidityInspection
     * @return false|string
     * @throws JsonException
     */
    public function __toString()
    {
        return json_encode($this->collection, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @return mixed
     * @noinspection PhpUnused
     */
    public function last()
    {
        return $this->collection[$this->count()-1];
    }


    /**
     * @return array
     */
    public function toArray():array
    {
        return array_map('get_object_vars', $this->collection);
    }
    /**
     * @return false|string
     * @throws JsonException
     */
    public function toJson():string
    {
        return json_encode($this->collection, JSON_THROW_ON_ERROR |JSON_PRETTY_PRINT, 512);
    }
    /**
     * @param string $delimiter
     * @return string
     */
    public function implode($delimiter=','):string
    {
        return implode($delimiter, array_column($this->toArray(), array_key_first($this->toArray()[0])));
    }
    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->collection= ModelMacro::getMethod($name)->call($this, $arguments);
        return $this;
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }

    /**
     * @param Closure $closure
     * @return $this
     */
    public function filter(Closure $closure): Collection
    {
        $filtered=array_filter($this->collection, $closure);
        return $this->setCollection(array_values($filtered));
    }

    /**
     * @param Closure $closure
     * @return Collection
     */
    public function map(Closure $closure): Collection
    {
        return $this->setCollection(array_map($closure, $this->collection));
    }
    /**
     * @param Closure $closure
     * @return Collection
     */
    public function each(Closure $closure): Collection
    {
        array_walk($this->collection, $closure);
        return $this;
    }
    /**
     * @param array $collection
     * @return Collection
     * @noinspection PhpUnused
     */
    public function setCollection(array $collection): Collection
    {
        $this->collection = $collection;
        return $this;
    }
}
