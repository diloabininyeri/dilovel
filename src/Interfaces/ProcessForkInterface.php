<?php


namespace App\Interfaces;

use Closure;
use Generator;

/**
 * Interface ProcessForkInterface
 * @package App\Interfaces
 */
interface ProcessForkInterface
{


    /**
     * @return Closure
     */
    public function closure():Closure;


    /**
     * @param $error
     * @return mixed
     */
    public function failed($error);


    /**
     * @return Generator
     */
    public function generateData(): Generator;
}
