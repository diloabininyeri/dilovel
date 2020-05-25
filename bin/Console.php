<?php


namespace Bin;

use Bin\Commands\ClearViewCacheCommand;
use Bin\Commands\CommandList;
use Bin\Commands\CreateBladeFilterCommand;
use Bin\Commands\CreateCommand;
use Bin\Commands\CreateControllerCommand;
use Bin\Commands\CreateCustomRequestCommand;
use Bin\Commands\CreateMiddlewareCommand;
use Bin\Commands\CreateModelCommand;
use Bin\Commands\CreateQueueClassCommand;
use Bin\Commands\CreateRuleCommand;
use Bin\Commands\CreateViewCommand;
use Bin\Commands\DeleteControllerCommand;
use Bin\Commands\ErrorLogChangedCommand;
use Bin\Commands\QueueListenCommand;
use Bin\Commands\QueueListenStatusCommand;
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
        'make:controller' => CreateControllerCommand::class,
        'delete:controller' => DeleteControllerCommand::class,
        'make:model' => CreateModelCommand::class,
        'make:view' => CreateViewCommand::class,
        'clear:view-cache' => ClearViewCacheCommand::class,
        'list' => CommandList::class,
        'make:middleware'=>CreateMiddlewareCommand::class,
        'error:detected'=>ErrorLogChangedCommand::class,
        'serve' => ServeCommand::class,
        'make:command' => CreateCommand::class,
        'blade:filter'=>CreateBladeFilterCommand::class,
        'make:request'=>CreateCustomRequestCommand::class,
        'make:rule'=>CreateRuleCommand::class,
        'make:queue'=>CreateQueueClassCommand::class,
        'queue:listen'=>QueueListenCommand::class,
        'queue:status'=>QueueListenStatusCommand::class,
    ];
}
