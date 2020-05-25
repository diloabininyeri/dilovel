<?php


namespace Bin\Commands;

use App\Components\Queue\MessageQueueConsumer;
use App\Interfaces\QueueInterface;
use Bin\Components\CommandInterface;
use Exception;

class QueueListenCommand implements CommandInterface
{
    protected string $description = 'listen the queue default queue name is default';

    /** @noinspection UnserializeExploitsInspection */
    public function handle(?array $parameters): void
    {
        $queue=$parameters[0] ?? 'default';
        MessageQueueConsumer::listenWithCallback($queue, function ($a) {
            /**
             * @var QueueInterface $obj
             */
            $obj=unserialize($a);
            try {
                echo $obj->handle().PHP_EOL;
            } catch (Exception $exception) {
                $obj->failed($exception);
            }
        });
    }
}
