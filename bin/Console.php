<?php


namespace Bin;

use Bin\Commands\ClearViewCacheCommand;
use Bin\Commands\CommandList;
use Bin\Commands\CreateControllerCommand;
use Bin\Commands\CreateMiddlewareCommand;
use Bin\Commands\CreateModelCommand;
use Bin\Commands\CreateViewCommand;
use Bin\Commands\CustomCommand;
use Bin\Commands\DeleteControllerCommand;
use Bin\Commands\ErrorLogChangedCommand;
use Bin\Commands\ServeCommand;
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
        'delete:controller' => DeleteControllerCommand::class,
        'make:model' => CreateModelCommand::class,
        'make:view' => CreateViewCommand::class,
        'clear:view-cache' => ClearViewCacheCommand::class,
        'list' => CommandList::class,
        'make:middleware'=>CreateMiddlewareCommand::class,
        'error:detected'=>ErrorLogChangedCommand::class,
        'serve' => ServeCommand::class,
    ];
}
