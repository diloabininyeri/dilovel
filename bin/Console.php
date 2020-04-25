<?php


namespace Bin;


use Bin\Commands\CustomCommand;
use Bin\Components\CustomCommandCall;

class Console extends CustomCommandCall
{

    protected array $commands=[
        'make:command'=>CustomCommand::class
    ];

}