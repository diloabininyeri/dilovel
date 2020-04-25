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
        $name = $parameters[0];
        $fileName = $this->createFileName($name);

        echo $this->createController($name, $fileName);

    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createController($name, $path): string
    {
        if (!file_exists($path)) {
            file_put_contents($path, $this->controllerTemplate($name));
            return "$name controller created";
        }

        return 'controller already exists';
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