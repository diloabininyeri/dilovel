<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

/**
 * Class CreateMiddlewareCommand
 * @package Bin\Commands
 */
class CreateMiddlewareCommand implements CommandInterface
{

    /**
     * @var string $namespace
     */
    private string $namespace = 'src/Application/Middleware';
    /**
     * @var string
     */
    protected string  $description='create middleware command';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createMiddleware($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createMiddleware($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("\nmiddleware already exists\n", 'red');
        }

        file_put_contents($path, $this->middlewareTemplate($name));

        return ColorConsole::getInstance()->getColoredString("\n$name middleware created\n", 'green');
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
    private function middlewareTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/middleware');
        return str_replace('$name', $className, $stub);
    }
}
