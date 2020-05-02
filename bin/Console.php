<?php


namespace Bin;


use Bin\{Commands\ClearViewCacheCommand,
    Commands\CommandList,
    Commands\CreateControllerCommand,
    Commands\CreateMiddlewareCommand,
    Commands\CreateModelCommand,
    Commands\CreateViewCommand,
    Commands\CustomCommand,
    Commands\DeleteControllerCommand,
    Components\CustomCommandCall};

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
        'delete:controller' => DeleteControllerCommand::class,
        'make:model' => CreateModelCommand::class,
        'make:view' => CreateViewCommand::class,
        'clear:view-cache' => ClearViewCacheCommand::class,
        'list' => CommandList::class,
        'make:middleware'=>CreateMiddlewareCommand::class
    ];

}