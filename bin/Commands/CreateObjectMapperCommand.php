<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;

class CreateObjectMapperCommand
{

    /**
     * @var string
     */
    private string $namespace = 'src/Application/Mappers';


    /**
     * @var string $description
     */
    protected string $description='create mapper object';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createMapper($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createMapper($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("mapper object already exists\n", 'red');
        }

        file_put_contents($path, $this->mapperTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name mapper created\n", 'green');
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
    private function mapperTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/mapper');
        return str_replace('$name', $className, $stub);
    }
}
