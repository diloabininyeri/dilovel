<?php


namespace App\Application\Controllers\Pipes;

use App\Interfaces\PipeAble;

/**
 * Class PipeTest2
 * @package App\Application\Controllers\Pipes
 */
class PipeTest2 implements PipeAble
{

    /**
     * @param $data
     * @param PipeAble $next
     * @return PipeAble
     */
    public function condition($data, PipeAble $next)
    {
        return $next;
    }
}
