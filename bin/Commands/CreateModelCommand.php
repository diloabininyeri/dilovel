<?php


namespace Bin\Commands;


use Bin\Components\CommandInterface;

class CreateModelCommand implements CommandInterface
{

    protected string $description='create model';

    public function handle(?array $parameters): void
    {
        print_r($parameters);
    }

}