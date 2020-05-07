<?php


namespace App\Interfaces;

/**
 * Interface BladeFilterInterface
 * @package App\Interfaces
 */
interface BladeFilterInterface
{

    /**
     * @param $value
     * @return mixed
     */
    public function filter($value);
}
