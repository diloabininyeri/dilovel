<?php


namespace Bin\Commands;

use App\Application\seeds\Builder\DatabaseSeeder;
use App\Interfaces\SeedInterface;
use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

/**
 * Class DatabaseSeedRunCommand
 * @package Bin\Commands
 */
class DatabaseSeedRunCommand implements CommandInterface
{
    /**
     * @var string
     */
    protected string $description = 'add all seeds to the database';

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $databaseSeeder=new DatabaseSeeder();
        $seeds=$databaseSeeder->seeds();
        foreach ($seeds as $seed) {
            call_user_func([new  $seed,'create']);
            $this->printClassName($seed);
        }
        sleep(1);
        echo PHP_EOL.ColorConsole::getInstance()->getColoredString('operation completed', 'green').PHP_EOL;
    }

    /**
     * @param string $seed
     */
    private function printClassName(string $seed):void
    {
        echo PHP_EOL.ColorConsole::getInstance()->getColoredString("$seed saved", 'green');
    }
}
