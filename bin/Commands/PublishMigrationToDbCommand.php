<?php


namespace Bin\Commands;

use App\Components\Database\Migration\CallMigrationObjects;
use App\Components\Database\Migration\MigrationStorage;
use Bin\Components\CommandInterface;

class PublishMigrationToDbCommand implements CommandInterface
{
    protected string $description='create all tables from migrations';

    public function handle(?array $parameters): void
    {
        CallMigrationObjects::create();
        $migrations= MigrationStorage::all();
        print_r($migrations);
    }
}
