<?php


namespace Bin\Commands;

use App\Bootstrap\Application;
use Bin\Components\CommandInterface;
use function Composer\Autoload\includeFile;

class RouteListCommand implements CommandInterface
{
    public function handle(?array $parameters): void
    {
    }
}
