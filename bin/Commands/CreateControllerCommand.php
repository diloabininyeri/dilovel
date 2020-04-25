<?php

namespace Bin\Commands;

use Bin\Components\CommandInterface;

/**
 * Class CreateControllerCommand
 * @package Bin\Commands
 */
class CreateControllerCommand implements CommandInterface
{
    /**
     * @var string
     */
    private string $namespace = 'src/app/Controllers/';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $fileName = $this->createFileName($parameters[0]);
        $name = $parameters[0];
        if (!file_exists($fileName)) {
            file_put_contents($fileName, $this->controllerTemplate($name));
            echo "$name controller created";
        } else {
            echo 'controller already exists';
        }

    }

    /**
     * @param $name
     * @return string
     */
    private function createFileName($name): string
    {
        return sprintf('%s/%s.php', $this->namespace, $name);
    }

    /**
     * @param $className
     * @return false|string|string[]
     */
    private function controllerTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/Controller');
        return str_replace('$name', $className, $stub);
    }
}