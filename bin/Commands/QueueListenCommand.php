<?php


namespace Bin\Commands;

use App\Components\Queue\MessageQueueConsumer;
use App\Interfaces\QueueInterface;
use Bin\Components\CommandInterface;
use ErrorException;
use Exception;

/**
 * Class QueueListenCommand
 * @package Bin\Commands
 */
class QueueListenCommand implements CommandInterface
{
    /**
     * @var string
     */
    protected string $description = 'listen the queue default queue name is default';

    /**
     * @param array|null $parameters
     * @throws ErrorException
     */
    public function handle(?array $parameters): void
    {
        $queue = $parameters[0] ?? 'default';
        MessageQueueConsumer::run($queue)->with(static function ($a) {
            /**
             * @var QueueInterface $obj
             */
            $obj = unserialize($a, ['allowed_class'=>true]);
            try {
                echo $obj->handle() . PHP_EOL;
            } catch (Exception $exception) {
                $obj->failed($exception);
            }
        });
    }
}
