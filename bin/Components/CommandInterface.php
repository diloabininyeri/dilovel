<?php
namespace Bin\Components;

/**
 * Interface CommandInterface
 * @package Bin\Components
 */
interface CommandInterface
{
    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters):void ;
}
