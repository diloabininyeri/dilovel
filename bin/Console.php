<?php


namespace Bin;


use Bin\Commands\CommandList;
use Bin\Commands\CreateControllerCommand;
use Bin\Commands\CreateModelCommand;
use Bin\Commands\CreateViewCommand;
use Bin\Commands\CustomCommand;
use Bin\Components\CustomCommandCall;

/**
 * Class Console
 * @package Bin
 */
class Console extends CustomCommandCall
{

    /**
     * @var array|string[]
     */
    protected array $commands = [
        'make:command' => CustomCommand::class,
        'make:controller' => CreateControllerCommand::class,
        'make:model' => CreateModelCommand::class,
        'make:view' => CreateViewCommand::class,
        'list'=>CommandList::class,
    ];

}