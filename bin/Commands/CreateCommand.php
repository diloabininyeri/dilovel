<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateCommand implements CommandInterface
{

    /**
     * @var string
     */
    private string $namespace = 'bin/Commands';


    /**
     * @var string $description
     */
    protected string $description='Creating a custom command is very simple';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createCommand($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createCommand($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("command already exists\n", 'red');
        }

        file_put_contents($path, $this->controllerTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name command created\n", 'green');
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
    private function controllerTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/command');
        return str_replace('$name', $className, $stub);
    }
}
