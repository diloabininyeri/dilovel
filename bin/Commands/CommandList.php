<?php


namespace Bin\Commands;


use App\Components\Reflection\ProtectedProperty;
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

        $commandList = Command::list();
        foreach ($commandList as $command => $class) {

            echo str_pad($command, 50, ' ', STR_PAD_RIGHT) . $this->getDescription(new $class) . "\n";
        }
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