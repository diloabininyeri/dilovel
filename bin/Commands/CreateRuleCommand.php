<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

class CreateRuleCommand implements CommandInterface
{
    /**
     * @var string
     */
    private string $namespace = 'src/Application/Rules';


    /**
     * @var string $description
     */
    protected string $description = 'create custom Rule for form validation';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createRule($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createRule($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("rule already exists\n", 'red');
        }

        file_put_contents($path, $this->ruleTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name rule created\n", 'green');
    }

    /**
     * @param $name
     * @return string
     */
    private function createFilePath($name): string
    {
        return sprintf('%s/%sRule.php', $this->namespace, $name);
    }

    /**
     * @param $className
     * @return false|string|string[]
     */
    private function ruleTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/rule');
        return str_replace('$name', "{$className}Rule", $stub);
    }
}
