<?php


namespace Bin\Commands;

use App\Components\Database\Migration\CallMigrationObjects;
use App\Components\Database\Migration\MigrationStorage;
use App\Components\Database\PDOAdaptor;
use Bin\Components\CommandInterface;

class PublishMigrationToDbCommand implements CommandInterface
{
    protected string $description = 'create all tables from migrations';

    public function handle(?array $parameters): void
    {
        CallMigrationObjects::create();
        $migrations = MigrationStorage::all();
        $tables = array_keys($migrations);

        foreach ($tables as $table) {
            $sql = "CREATE TABLE $table(";
            foreach ($migrations[$table] as $key => $value) {
                foreach ($value as $itemKey => $itemValue) {
                    if ($itemKey === 'column_name') {
                        $columnName = $itemValue;
                    }
                    if ($itemKey === 'length') {
                        $length = $itemValue;
                    }
                    if ($itemKey === 'type') {
                        $type = $itemValue;
                    }
                }
                if (!in_array($type, ['TEXT', 'LONGTEXT'])) {
                    $sql .= "$columnName $type($length),";
                } else {
                    $sql .= "$columnName $type,";
                }
            }
            $sql = rtrim($sql, ',');
            $sql .= ")";

            echo PDOAdaptor::connection($migrations[$table][0]['connection_name'])->exec($sql) ?: "$table created" . PHP_EOL;
        }
    }
}
