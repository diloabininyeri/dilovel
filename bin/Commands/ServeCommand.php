<?php


namespace Bin\Commands;

use Bin\Components\CommandInterface;

/**
 * Class ServeCommand
 * @package Bin\Commands
 */
class ServeCommand implements CommandInterface
{
    /**
     * @var string $description
     */
    protected string  $description='app serve with command "php console serve" or "php console serve host=127.0.0.1 port=8888"';
    /**
     * @var string $host
     */
    private string $host = '127.0.0.1';

    /**
     * @var int $port
     */
    private int $port = 8000;

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $parseHostAndPort = $this->parsePortAndHost($parameters);
        $host = $parseHostAndPort['host'] ?? $this->host;
        $port = $parseHostAndPort['port'] ?? $this->port;
        $output = shell_exec("php -S $host:$port");
        echo "<pre>$output</pre>";
    }

    /**
     * @param array $parameters
     * @return array
     */
    private function parsePortAndHost(array $parameters): array
    {
        $parameters = array_map('trim', $parameters);
        $signal = [];

        foreach ($parameters as $key => $value) {
            [$signalKey, $signalValue] = explode('=', $value);
            $signal[$signalKey] = $signalValue;
        }

        return $signal;
    }
}
