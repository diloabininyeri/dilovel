<?php


namespace Bin\Commands;


use App\Components\Reflection\ProtectedProperty;
use Bin\Components\Animation;
use Bin\Components\Command;
use Bin\Components\CommandInterface;
use ReflectionException;

/**
 * Class CommandList
 * @package Bin\Commands
 */
class CommandList implements CommandInterface
{

    /**
     * @var string
     */
    protected string $description = 'list all available commands for console';

    /**
     * @param array|null $parameters
     * @throws ReflectionException
     */
    public function handle(?array $parameters): void
    {
        Animation::show();
        $this->printAllCommandList(Command::list());


    }

    /**
     * @param $commandList
     * @throws ReflectionException
     */
    private function printAllCommandList($commandList): void
    {
        foreach ($commandList as $command => $class) {
            echo $this->addPadRight($command) . $this->getDescription(new $class) . "\n";
        }
    }

    /**
     * @param $command
     * @return string
     */
    private function addPadRight($command): string
    {
       return  str_pad($command, 50, ' ', STR_PAD_RIGHT);
    }
    /**
     * @param $object
     * @return mixed
     * @throws ReflectionException
     */
    private function getDescription($object)
    {
        return (new ProtectedProperty())
            ->setObject($object)
            ->setProperty('description')
            ->getValue();
    }

}