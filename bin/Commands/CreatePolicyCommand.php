<?php


namespace Bin\Commands;

use Bin\Components\ColorConsole;

class CreatePolicyCommand
{

    /**
     * @var string
     */
    private string $namespace = 'src/Application/Policies';


    /**
     * @var string $description
     */
    protected string $description='create policy is very simple';


    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $name = $parameters[0];
        $filePath = $this->createFilePath($name);

        echo $this->createPolicy($name, $filePath);
    }

    /**
     * @param $name
     * @param $path
     * @return string
     */
    private function createPolicy($name, $path): string
    {
        if (file_exists($path)) {
            return ColorConsole::getInstance()->getColoredString("policy already exists\n", 'red');
        }

        file_put_contents($path, $this->policyTemplate($name));

        return ColorConsole::getInstance()->getColoredString("$name policy created\n", 'green');
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
    private function policyTemplate($className)
    {
        $stub = file_get_contents(__DIR__ . '/../Stubs/policy');
        return str_replace('$name', $className, $stub);
    }
}
