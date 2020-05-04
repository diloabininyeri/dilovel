<?php /**@noinspection PhpUnused */

namespace Bin\Commands;

use Bin\Components\ColorConsole;
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
    private string $namespace = 'src/Application/Controllers';


    /**
     * @var string $description
     */
    protected string $description='Creating a controller is very simple';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createController($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createController($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("controller already exists\n", 'red');
        }

        file_put_contents($path, $this->controllerTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name controller created\n", 'green');
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
        $stub = file_get_contents(__DIR__ . '/../Stubs/Controller');
        return str_replace('$name', $className, $stub);
    }
}
