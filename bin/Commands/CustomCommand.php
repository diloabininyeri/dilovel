<?php

namespace Bin\Commands;

use Bin\Components\CommandInterface;

/**
 * Class CustomCommand
 * @package Bin\Commands
 */
class CustomCommand implements CommandInterface
{

    /**
     * @var string $namespace
     */
    private string $namespace='Bin/Commands';
    /**
     * @var string
     */
    public string $description = 'for example description etc ...';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        echo 'executed custom console commands';
        print_r($parameters);
    }
}
