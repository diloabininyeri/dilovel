<?php


namespace Bin\Commands;

use App\Components\Database\Migration\CallMigrationObjects;
use Bin\Components\CommandInterface;

class DropTableFromMigrations implements CommandInterface
{
    protected string $description = 'drop tables from migrations';

    public function handle(?array $parameters): void
    {
        CallMigrationObjects::drop();
    }
}
