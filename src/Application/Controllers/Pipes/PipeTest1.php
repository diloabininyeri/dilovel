<?php


namespace App\Application\Controllers\Pipes;

use App\Interfaces\PipeAble;

/**
 * Class PipeTest1
 * @package App\Application\Controllers\Pipes
 */
class PipeTest1 implements PipeAble
{

    /**
     * @param $data
     * @param PipeAble $next
     * @return PipeAble|string
     */
    public function condition($data, PipeAble $next)
    {
        if (strlen($data) > 5) {
            return $next;
        }
        return 'les then 5';
    }
}
