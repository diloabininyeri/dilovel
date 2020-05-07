<?php


namespace App\Components\Blade\Filter;

/**
 * Class AbstractBladeFilter
 * @package App\Components\Blade\Filter
 */
abstract class AbstractBladeFilter
{

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    final public function filter($name, $value)
    {
        $class = $this->getFilterArray()[$name];
        return (new $class)->filter($value);
    }

    /**
     * @return mixed
     */
    private function getFilterArray()
    {
        return $this->filters;
    }
}
