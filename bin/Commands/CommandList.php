<?php /**@noinspection PhpUnused */


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
        //Animation::show();
        echo $this->printTextBanner();
        echo "\n";
        $this->printAllCommandList(Command::list());
    }

    /**
     * @param $commandList
     */
    private function printAllCommandList($commandList): void
    {
        $commandListByFirstLetter = ($this->groupByFirstLetter($commandList));
        array_map([$this, 'printGroupBy'], $commandListByFirstLetter);
    }

    /**
     * @param $commandList
     * @throws ReflectionException
     */
    private function printGroupBy($commandList): void
    {
        echo str_repeat("\n", 1);

        foreach ($commandList as $command => $class) {
            echo "\t" . $this->addPadRight($command) . $this->getDescription(new $class) . "\n";
        }
    }

    /**
     * @param $commandList
     * @return array
     */
    private function groupByFirstLetter($commandList): array
    {
        $commandGroupBy = [];

        foreach ($commandList as $key => $command) {
            $letter = $key[0];
            $commandGroupBy[$letter][$key] = $command;
        }

        return $commandGroupBy;
    }

    /**
     * @param $command
     * @return string
     */
    private function addPadRight($command): string
    {
        return str_pad($command, 30, ' ', STR_PAD_RIGHT);
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


    private function printTextBanner(): string
    {
        $text= '
                 __        __                      __      ___  __              ___       __   __       
                |__) |__| |__)    |__|  |\/| \  / /  `    |__  |__)  /\   |\/| |__  |  | /  \ |__) |__/ 
                |    |  | |       |  |  |  |  \/  \__,    |    |  \ /~~\  |  | |___ |/\| \__/ |  \ |  \ ';

        return "\033[1m$text\033[0m";
    }
}
