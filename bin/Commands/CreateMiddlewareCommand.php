<?php


namespace Bin\Commands;


use Bin\Components\CommandInterface;

class CreateMiddlewareCommand implements CommandInterface
{

    protected  string  $description='create middleware command';

    public function handle(?array $parameters): void
    {
        // TODO: Implement handle() method.
    }
}