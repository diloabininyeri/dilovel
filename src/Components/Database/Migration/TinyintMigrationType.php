<?php


namespace App\Components\Database\Migration;

class TinyintMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;

    private string $type='TINYINT';

    /**
     * StringMigrationType constructor.
     * @param string $table
     * @param string $column
     * @param $connectionName
     */
    public function __construct(string $table, string $column, $connectionName)
    {
        $this->table = $table;
        $this->column = $column;
        $this->connectionName = $connectionName;
        $this->length=3;
    }
}
