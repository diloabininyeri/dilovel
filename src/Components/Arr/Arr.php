<?php


namespace App\Components\Arr;

/**
 * Class Arr
 * @package App\Components\Arr
 */
class Arr
{

    /**
     * @param ArrayMapper $mapper
     * @param array $array
     * @return ArrayMapper[]|array
     */
    public static function mapper(ArrayMapper $mapper, array $array):array
    {
        return array_map(fn ($item) =>clone $mapper($item), $array);
    }
}
