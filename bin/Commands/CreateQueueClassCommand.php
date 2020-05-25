<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;

/**
 * Class CreateQueueClassCommand
 * @package Bin\Commands
 */
class CreateQueueClassCommand
{

    /**
     * @var string
     */
    private string $namespace = 'src/Application/Queue';


    /**
     * @var string $description
     */
    protected string $description='Creating a queue is very simple';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createQueue($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createQueue($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("queue already exists\n", 'red');
        }

        file_put_contents($path, $this->queueTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name queue created\n", 'green');
    }

    /**
     * @param $name
     * @return string
     */
    private function createFilePath($name): string
    {
        return sprintf('%s/%s.php', $this->namespace, $name);
    }

    /**
     * @param $className
     * @return false|string|string[]
     */
    private function queueTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/queue');
        return str_replace('$name', $className, $stub);
    }
}
