<?php /**@noinspection PhpUnused*/


namespace Bin\Commands;

use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;

/**
 * Class ClearViewCacheCommand
 * @package Bin\Commands
 */
class ClearViewCacheCommand implements CommandInterface
{
    /**
     * @var ColorConsole
     */
    private ColorConsole $console;

    /**
     * @var string
     */
    protected string $description = 'clear all vew cache';

    public function __construct()
    {
        $this->console = ColorConsole::getInstance();
    }

    /**
     * @param array|null $parameters
     */
    public function handle(?array $parameters): void
    {
        $caches = glob('src/Views/caches/*.php');

        if (empty($caches)) {
            echo $this->console->getColoredString("not found view cache\n", 'red');
        }

        $this->deleteAllViewCache($caches);
    }

    /**
     * @param $caches
     */
    private function deleteAllViewCache($caches): void
    {
        foreach ($caches as $cache) {
            unlink($cache);
            echo $this->console->getColoredString("$cache deleted\n", 'green');
            usleep(500000);
        }
    }
}
