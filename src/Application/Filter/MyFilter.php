<?php


namespace App\Application\Filter;

use App\Interfaces\BladeFilterInterface;

/**
 * Class PhoneFilter
 * @package App\Application\Filter
 */
class MyFilter implements BladeFilterInterface
{

    /**
     * @param $value
     * @return mixed|string
     */
    public function filter($value)
    {
       return  $value;
    }
}
