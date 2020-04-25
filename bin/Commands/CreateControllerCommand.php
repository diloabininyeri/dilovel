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
        if (!file_exists($this->createFileName($parameters[0]))) {
            file_put_contents($this->createFileName($parameters[0]), $this->controllerTemplate($parameters[0]));
        }
        else {
            echo 'controller already exists';
        }

    }

    /**
     * @param $name
     * @return string
     */
    private function createFileName($name)
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