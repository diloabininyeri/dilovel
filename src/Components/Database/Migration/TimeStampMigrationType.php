<?php


namespace App\Components\Database\Migration;

/**
 * Class TimeStampMigrationType
 * @package App\Components\Database\Migration
 */
class TimeStampMigrationType extends AbstractMigrationDataType
{
    /**
     * @var string
     */
    private string $type = 'TIMESTAMP';

    public function __construct(string $table, $connectionName, $column=null)
    {
        $this->table = $table;
        $this->length=6;
        $this->connectionName = $connectionName;
    }

    private function createStorageData(...$columns): void
    {
        foreach ($columns as $column) {
            MigrationStorage::add($this->table, $this->connectionName, [
                'column_name' => $column,
                'type' => $this->type,
                'nullable' => $this->isNullable,
                'length' => $this->length ?? null,
                'unique' => $this->isUnique,
                'auto_increment' => $this->isAutoIncrement ?? false,
                'primary_key' => $this->isPrimaryKey ?? false,

            ]);
        }
    }


    public function __destruct()
    {
        $this->createStorageData('created_at', 'updated_at');
    }
}
