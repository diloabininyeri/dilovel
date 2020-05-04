<?php /**@noinspection PhpUnused */


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

/**
 * Class CreateModelCommand
 * @package Bin\Commands
 */
class CreateModelCommand implements CommandInterface
{
    private string $namespace = 'src/Application/Models';

    /**
     * @var string
     */
    protected string $description = 'create model magic objects and magic model as orm ';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        [$className,] = $parameters;
        $filePath = $this->createFilePath($className);

        echo $this->createModel($className, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createModel($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("model already exists\n", 'red');
        }

        file_put_contents($path, $this->modelTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name model created\n", 'green');
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
    private function modelTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/Model');
        return str_replace('$name', $className, $stub);
    }
}
