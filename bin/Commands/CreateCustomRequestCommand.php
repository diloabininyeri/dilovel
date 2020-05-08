<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateCustomRequestCommand implements CommandInterface
{
    /**
     * @var string
     */
    private string $namespace = 'src/Application/Request';


    /**
     * @var string $description
     */
    protected string $description = 'create custom request for form validation';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createRequest($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createRequest($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("request already exists\n", 'red');
        }

        file_put_contents($path, $this->requestTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name request created\n", 'green');
    }

    /**
     * @param $name
     * @return string
     */
    private function createFilePath($name): string
    {
        return sprintf('%s/%sRequest.php', $this->namespace, $name);
    }

    /**
     * @param $className
     * @return false|string|string[]
     */
    private function requestTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/request');
        return str_replace('$name', "{$className}Request", $stub);
    }
}
