<?php


namespace App\Components\Database\Migration\MysqlType;

use App\Components\Database\Migration\AbstractMigrationDataType;
use App\Components\Database\Traits\MigrationDataTypeDestructTrait;

/**
 * Class BigIntegerMigrationType
 * @package App\Components\Database\Migration\MysqlType
 */
class BigIntegerMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;

    /**
     * @var string
     */
    private string $type = 'BIGINT';

    /**
     * BigIntegerMigrationType constructor.
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
