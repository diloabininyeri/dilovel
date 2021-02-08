<?php

namespace App\Components\Collection;

use App\Components\Traits\ConditionAble;
use App\Interfaces\ArrayAble;
use App\Interfaces\ToJson;
use App\Components\Database\ModelMacro;
use ArrayAccess;
use ArrayIterator;
use Carbon\Carbon;
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
    use ConditionAble;

    /**
     * @var array $collection
     */
    private array  $collection;

    /**
     * Collection constructor.
     * @param array $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
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
        return $this->collection;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
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
        return $this->collection[0] ?? null;
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
        return end($this->collection);
    }

    /**
     * @param string $column
     * @return array
     */
    public function column(string $column): array
    {
        return array_map(fn ($i) => $i[$column], $this->toArray());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map('get_object_vars', $this->collection);
    }

    /**
     * @return false|string
     * @throws JsonException
     */
    public function toJson(): string
    {
        header('Content-type:application/json');
        return json_encode($this->collection, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT, 512);
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function implode($delimiter = ','): string
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
        $this->collection = ModelMacro::getMethod($name)->call($this, $arguments);
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
        $filtered = array_filter($this->collection, $closure);
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

    public function shuffle(): self
    {
        shuffle($this->collection);
        return new self($this->collection);
    }

    /**
     * @param int $count
     * @return $this
     */
    public function random(int $count = 1): self
    {
        shuffle($this->collection);
        return new self(array_slice($this->collection, 0, $count));
    }

    public function chunk(int $count, bool $reIndex = false)
    {
        $this->collection = array_chunk($this->collection, $count, $reIndex);
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function withDefault(array $data): self
    {
        array_walk($this->collection, function ($item) use ($data) {
            foreach ($data as $key => $value) {
                if ($item->$key === null) {
                    $item->$key = $value;
                }
            }
        });
        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function withAttributes(array $attributes): self
    {
        array_walk($this->collection, static function ($item) use ($attributes) {
            foreach ($attributes as $key => $value) {
                $item->$key = $value;
            }
        });
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

    /**
     * @param $item
     * @param int $index
     * @return Collection
     */
    public function insertNewItem($item, int $index): Collection
    {
        $newCollection = array_merge(
            array_slice($this->collection, 0, $index),
            [$item],
            array_slice($this->collection, $index)
        );
        return $this->setCollection($newCollection);
    }

    /**
     * @param string $field
     * @return float
     */
    public function total(string $field): float
    {
        $total = 0;
        foreach ($this->collection as $collection) {
            $total += $collection->$field ?? $collection[$field];
        }
        return $total;
    }

    /**
     * @param string $attribute
     * @param callable $closure
     * @return $this
     */
    public function setAttribute(string $attribute, callable $closure): self
    {
        array_walk($this->collection, static function ($item) use ($attribute, $closure) {
            $item->$attribute = $closure($item->$attribute);
        });

        return $this;
    }


    /**
     * @return $this
     */
    public function toDiffForHumans(): self
    {
        $this->setAttribute('created_at', fn ($createdAt) => Carbon::parse($createdAt)->diffForHumans());
        $this->setAttribute('updated_at', fn ($createdAt) => Carbon::parse($createdAt)->diffForHumans());
        return $this;
    }

    /**
     * @param $oldName
     * @param $newName
     * @param bool $delete
     * @return $this
     */
    public function renameAttribute($oldName, $newName, $delete = true): self
    {
        array_walk($this->collection, static function ($collection) use ($oldName, $newName, $delete) {
            $collection->$newName = $collection->$oldName;
            if ($delete) {
                unset($collection->$oldName);
            }
        });
        return $this;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function unique(string $field): self
    {
        $unique_collection = [];
        while (count($this->collection) > 0) {
            $element = array_shift($this->collection);
            $unique_collection[] = $element;
            $this->collection = array_udiff($this->collection, [$element], fn ($prev, $next) => $prev->$field <=> $next->$field);
        }

        return $this->setCollection($unique_collection);
    }

    /**
     * @param int $start
     * @param null $length
     * @return $this
     */
    public function slice(int $start, $length = null): self
    {
        $this->collection = array_slice($this->collection, $start, $length);
        return $this;
    }

    /**
     * @param array $attributes
     * @param string $concat
     * @param bool $delete
     * @return $this
     */
    public function combineAttributes(array $attributes, $concat = ' ', $delete=false): self
    {
        $this->each(static function ($item) use ($attributes, $concat) {
            $join = [];
            $name = [];
            foreach ($attributes as $attribute) {
                $join[] = $item->$attribute;
                $name[] = $attribute;
            }
            $item->{implode('_', $name)} = implode($concat, $join);
        });

        if ($delete) {
            $this->deleteAttribute(...$attributes);
        }

        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function sortByAsc(string $key):self
    {
        uasort($this->collection, fn ($a, $b) =>$a->$key<=>$b->$key);
        $this->collection = array_values($this->collection);
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function sortByDesc(string $key): Collection
    {
        uasort($this->collection, fn ($a, $b) =>-1*($a->$key<=>$b->$key));
        $this->collection = array_values($this->collection);
        return $this;
    }

    /**
     * @param string $key
     * @param string $direction
     * @return Collection
     */
    public function sortBy(string $key, string $direction='asc'): Collection
    {
        $method='sortBy'.ucfirst($direction);
        return $this->{$method}($key);
    }

    /**
     * @param string ...$attributes
     * @return $this
     */
    public function deleteAttribute(string ...$attributes): self
    {
        $this->each(static function ($item) use ($attributes) {
            foreach ($attributes as $attribute) {
                unset($item->$attribute);
            }
        });
        return  $this;
    }
}
