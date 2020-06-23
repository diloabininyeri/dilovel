<?php


namespace App\Components\Arr;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Class CanIterate
 * @package App\Components\Arr
 */
abstract class CanIterate implements IteratorAggregate
{
    /**
     * @return array
     */
    abstract public function toArray():array ;

    /**
     * @return ArrayIterator|Traversable
     */
    final public function getIterator()
    {
        if (method_exists($this, 'toArray')) {
            return new ArrayIterator($this->toArray());
        }
        return new ArrayIterator([]);
    }
}
