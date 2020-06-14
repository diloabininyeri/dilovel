<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateMailableCommand implements CommandInterface
{


    /**
     * @var string
     */
    private string $namespace = 'src/Application/Mail';


    /**
     * @var string $description
     */
    protected string $description='creating mailable object';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createMailable($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createMailable($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("mailable already exists\n", 'red');
        }

        file_put_contents($path, $this->mailableTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name mailable created\n", 'green');
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
    private function mailableTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/mail');
        return str_replace('$name', $className, $stub);
    }
}
