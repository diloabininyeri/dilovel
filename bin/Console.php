<?php


namespace Bin;

use Bin\Commands\ClearViewCacheCommand;
use Bin\Commands\CommandList;
use Bin\Commands\CreateBladeFilterCommand;
use Bin\Commands\CreateCommand;
use Bin\Commands\CreateControllerCommand;
use Bin\Commands\CreateCustomRequestCommand;
use Bin\Commands\CreateMailableCommand;
use Bin\Commands\CreateMiddlewareCommand;
use Bin\Commands\CreateMigrationCommand;
use Bin\Commands\CreateModelCommand;
use Bin\Commands\CreateObjectMapperCommand;
use Bin\Commands\CreatePolicyCommand;
use Bin\Commands\CreateQueueClassCommand;
use Bin\Commands\CreateRuleCommand;
use Bin\Commands\CreateViewCommand;
use Bin\Commands\DatabaseSeedRunCommand;
use Bin\Commands\DeleteControllerCommand;
use Bin\Commands\DropTableFromMigrations;
use Bin\Commands\ErrorLogChangedCommand;
use Bin\Commands\PublishMigrationToDbCommand;
use Bin\Commands\QueueListenCommand;
use Bin\Commands\QueueListenStatusCommand;
use Bin\Commands\RedisMessageConsumerCommand;
use Bin\Commands\RouteListCommand;
use Bin\Commands\ServeCommand;
use Bin\Commands\VersionCommand;
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
        'version'=>VersionCommand::class,
        'v'=>VersionCommand::class,
        '-v'=>VersionCommand::class,
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
        'make:policy'=>CreatePolicyCommand::class,
        'make:mapper'=>CreateObjectMapperCommand::class,
        'make:migration'=>CreateMigrationCommand::class,
        'make:mail'=>CreateMailableCommand::class,
        'migrations:publish'=>PublishMigrationToDbCommand::class,
        'migrations:drop'=>DropTableFromMigrations::class,
        'router:list'=>RouteListCommand::class,
        'redis:consumer'=>RedisMessageConsumerCommand::class,
        'db:seed'=>DatabaseSeedRunCommand::class,
    ];
}
