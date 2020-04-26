<?php


namespace Bin\Commands;


use Bin\Components\CommandInterface;

/**
 * Class CreateModelCommand
 * @package Bin\Commands
 */
class CreateModelCommand implements CommandInterface
{

    private string $namespace = 'src/app/Models/';

    /**
     * @var string
     */
    protected string $description = 'create model magic objects and magic model as orm ';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        [$className, $tableName] = $parameters;
        $filePath = $this->createFilePath($className);

        echo $this->createModel($className, $filePath, $tableName);

    }

    /**
     * @param $name
     * @param $path
     * @param $tableName
     * @return string
     */
    private function createModel($name, $path, $tableName): string
    {
        if (file_exists($path)) {
            return 'model already exists';
        }

        file_put_contents($path, $this->modelTemplate($name, $tableName));

        return "$name model created";

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
     * @param $tableName
     * @return false|string|string[]
     */
    private function modelTemplate($className, $tableName)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/Model');
        return str_replace(['$name', '$table_name'], [$className, $tableName], $stub);
    }


}