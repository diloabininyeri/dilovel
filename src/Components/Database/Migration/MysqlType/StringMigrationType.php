<?php


namespace App\Components\Database\Migration\MysqlType;

use App\Components\Database\Migration\AbstractMigrationDataType;
use App\Components\Database\Traits\MigrationDataTypeDestructTrait;

/**
 * Class StringMigrationType
 * @package App\Components\Database\Migration
 */
class StringMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;

    private string $type='VARCHAR';

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
    }
}
