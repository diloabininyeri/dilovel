<?php


namespace Bin\Commands;


use Bin\Components\CommandInterface;

class CreateModelCommand implements CommandInterface
{

    public function handle(?array $parameters): void
    {
        print_r($parameters);
    }

}