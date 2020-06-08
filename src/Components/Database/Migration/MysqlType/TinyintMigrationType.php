<?php


namespace App\Components\Database\Migration\MysqlType;

use App\Components\Database\Migration\AbstractMigrationDataType;
use App\Components\Database\Traits\MigrationDataTypeDestructTrait;

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
