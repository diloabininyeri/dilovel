<?php


namespace App\Application\Controllers\Pipes;

use App\Interfaces\PipeAble;

/**
 * Class PipeTest3
 * @package App\Application\Controllers\Pipes
 */
class PipeTest3 implements PipeAble
{


    /**
     * @param $data
     * @param PipeAble $next
     * @return PipeAble|string
     */
    public function condition($data, PipeAble $next)
    {
        if ($data === 'merhaba') {
            return $next;
        }
        return 'not equal is merhaba';
    }
}
