<?php


namespace Bin\Commands;

use App\Components\Queue\MessageQueue;
use Bin\Components\CommandInterface;

/**
 * Class QueueListenStatusCommand
 * @package Bin\Commands
 */
class QueueListenStatusCommand implements CommandInterface
{

    /**
     * @var string
     */
    protected string $description='get status of queue';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $queue=$parameters[0] ?? 'default';
        $messageQueue=new MessageQueue($queue);
        $status=$messageQueue->getStatus();
        $keys=['queue','message_count','listener_count'];
        foreach ($keys as $key) {
            $this->printStatusKey($key, $status);
        }
    }

    /**
     * @param $key
     * @param $status
     */
    private function printStatusKey($key, $status):void
    {
        $stringKey=str_pad($key, 50);
        echo sprintf('%s%s', str_replace('_', ' ', $stringKey), $status[$key]).PHP_EOL;
    }
}
