<?php


namespace Bin\Commands;

use Bin\Components\CommandInterface;

class PublishMigrationToDbCommand implements CommandInterface
{
    protected string $description='create all tables from migrations';

    public function handle(?array $parameters): void
    {
        // TODO: Implement handle() method.
    }
}
