<?php


namespace App\Components\Pipeline;

use App\Interfaces\PipeAble as NextAbleInterface;

/**
 * Class PipeAble
 * @package App\Components\Next
 */
class PipeAble implements NextAbleInterface
{

    /**
     * @param $data
     * @param NextAbleInterface $next
     */
    public function condition($data, NextAbleInterface $next)
    {
    }
}
