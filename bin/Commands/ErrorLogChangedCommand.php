<?php


namespace Bin\Commands;

use Bin\Components\CommandInterface;

/**
 * Class ErrorLogChangedCommand
 * @package Bin\Commands
 */
class ErrorLogChangedCommand implements CommandInterface
{

    /**
     * @var string
     */
    protected string  $description='auto-trigger when an error occurs, no need to call manually';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
    }
}
