<?php


namespace Bin\Commands;

use Bin\Components\CommandInterface;

class VersionCommand implements CommandInterface
{
    protected string $description = 'print output of version';
    public function handle(?array $parameters): void
    {
        echo  '1.0.0v'.PHP_EOL;
    }
}
