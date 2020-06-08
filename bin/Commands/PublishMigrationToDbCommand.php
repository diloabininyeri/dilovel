<?php


namespace Bin\Commands;

use App\Components\Database\Migration\CallMigrationObjects;
use App\Components\Database\Migration\MigrationStorage;
use App\Components\Database\PDOAdaptor;
use Bin\Components\ColorConsole;
use Bin\Components\CommandInterface;
use Exception;

/**
 * Class PublishMigrationToDbCommand
 * @package Bin\Commands
 */
class PublishMigrationToDbCommand implements CommandInterface
{
    /**
     * @var string
     */
    protected string $description = 'create all tables from migrations';


    /**
     * @param array|null $parameters
     * @throws Exception
     */
    public function handle(?array $parameters): void
    {
        CallMigrationObjects::create();
        $migrations = MigrationStorage::all();
        $tables = array_keys($migrations);

        $this->createTable($tables, $migrations);
    }

    /**
     * @param array $tables
     * @param array $migrations
     * @throws Exception
     */
    private function createTable(array $tables, array $migrations): void
    {
        $withoutLengths = [
            'TEXT',
            'LONGTEXT',
            'JSON',
            'LONGTEXT',
            'MEDIUMTEXT',
            'TINYTEXT'
        ];


        foreach ($tables as $table) {
            $sql = "CREATE TABLE IF NOT EXISTS $table (";
            foreach ($migrations[$table] as $key => $value) {
                if (in_array($value['type'], $withoutLengths, true)) {
                    $sql .= sprintf(
                        '%s %s %s%s %s %s,',
                        $value['column_name'],
                        $value['type'],
                        $value['nullable'] === true ? '' : 'NOT NULL',
                        (bool)$value['unique'] === true ? 'UNIQUE' : '',
                        $value['default'] !== null ? "DEFAULT {$value['default']}" : '',
                        $value['comment'] !== null ? "COMMENT '" . $value['comment'] . "'" : '',
                    );
                } else {
                    $sql .= sprintf(
                        '%s %s(%d) %s %s %s %s %s %s,',
                        $value['column_name'],
                        $value['type'],
                        $value['length'],
                        (bool)$value['primary_key'] === true ? 'PRIMARY KEY' : '',
                        (bool)$value['auto_increment'] === true ? 'AUTO_INCREMENT' : '',
                        $value['nullable'] === false ? 'NOT NULL' : '',
                        (bool)$value['unique'] === true ? 'UNIQUE' : '',
                        $value['default'] !== null ? "DEFAULT {$value['default']}" : '',
                        $value['comment'] !== null ? "COMMENT '" . $value['comment'] . "'" : '',
                    );
                }
            }
            $sql = rtrim($sql, ',');
            $sql .= ')';
            echo PDOAdaptor::connection($migrations[$table][0]['connection_name'])
                ->exec($sql) ?: ColorConsole::getInstance()
                ->getColoredString("$table migrated\n", 'green');
            usleep(200000);
        }
    }
}
