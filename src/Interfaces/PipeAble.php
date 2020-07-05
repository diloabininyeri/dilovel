<?php


namespace App\Interfaces;

/**
 * Interface PipeAble
 * @package App\Interfaces
 */
interface PipeAble
{
    /**
     * @param $data
     * @param PipeAble $next
     * @return mixed
     */
    public function condition($data, PipeAble $next);
}
