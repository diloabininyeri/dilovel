<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateMigrationCommand implements CommandInterface
{
    /**
     * @var string
     */
    private string $namespace = 'bin/Migrations';


    /**
     * @var string $description
     */
    protected string $description='create migration command';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createMigration($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createMigration($name, $path): string
    {
        file_put_contents($path, $this->migrationTemplate($name));
        return ColorConsole::getInstance()->getColoredString("$name migration created\n", 'green');
    }

    /**
     * @param $name
     * @return string
     */
    private function createFilePath($name): string
    {
        return sprintf('%s/%s.php', $this->namespace, $name.'_migration_'.date('Y_m_d_H:i'));
    }

    /**
     * @param $className
     * @return false|string|string[]
     */
    private function migrationTemplate($className)
    {
        $className=ucfirst($className);
        $stub = file_get_contents(__DIR__ . '/../Stubs/migration');
        return str_replace('$name', "{$className}CreateMigration", $stub);
    }
}
