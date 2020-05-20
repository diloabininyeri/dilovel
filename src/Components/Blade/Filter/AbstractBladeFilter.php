<?php


namespace App\Components\Blade\Filter;

use App\Application\Filter\PhoneFilter;
use App\Components\Exceptions\BladeFilterNotFoundException;
use App\Interfaces\BladeFilterInterface;
use Exception;

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
     * @throws BladeFilterNotFoundException
     * @see PhoneFilter::filter() for example using
     */
    final public function filter($name, $value)
    {
        try {
            $class = $this->getFilterArray()[$name];
            return (new $class)->filter($value);
        } catch (Exception $exception) {
            throw new BladeFilterNotFoundException(sprintf('%s filter not found in the %s::filters ', $name, BladeFilters::class));
        }
    }

    /**
     * @return mixed
     */
    private function getFilterArray()
    {
        return $this->filters;
    }
}
