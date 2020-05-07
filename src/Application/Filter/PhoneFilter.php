<?php


namespace App\Application\Filter;

use App\Interfaces\BladeFilterInterface;

/**
 * Class PhoneFilter
 * @package App\Application\Filter
 */
class PhoneFilter implements BladeFilterInterface
{

    /**
     * @param $value
     * @return mixed|string
     */
    public function filter($value)
    {
        $pattern = '/^0?(5[3|4|5]\d)(\d{3})(\d+)/m';
        preg_match_all($pattern, $value, $matches, PREG_SET_ORDER, 0);
        $find = $matches[0];

        return "'+90 $find[1] $find[2] $find[3]'";
    }
}
