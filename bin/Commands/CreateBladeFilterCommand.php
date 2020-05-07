<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateBladeFilterCommand implements CommandInterface
{
    protected string $description='create make custom filter for blade ,php blade:filter Phone';

    /**
     * @var string
     */
    private string $namespace = 'src/Application/Filter';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createFilter($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createFilter($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("filter already exists\n", 'red');
        }

        file_put_contents($path, $this->filterTemplate($name));

        return ColorConsole::getInstance()->getColoredString("{$name}Filter filter created\n", 'green');
    }

    /**
     * @param $name
     * @return string
     */
    private function createFilePath($name): string
    {
        return sprintf('%s/%sFilter.php', $this->namespace, $name);
    }

    /**
     * @param $className
     * @return false|string|string[]
     */
    private function filterTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/blade.filter');
        return str_replace('$name', "{$className}Filter", $stub);
    }
}
