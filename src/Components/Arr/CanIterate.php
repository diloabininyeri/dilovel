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
        return new ArrayIterator($this->toArray());
    }
}
