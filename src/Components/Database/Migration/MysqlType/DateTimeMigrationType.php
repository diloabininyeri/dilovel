<?php


namespace App\Components\Database\Migration\MysqlType;

use App\Components\Database\Migration\AbstractMigrationDataType;
use App\Components\Database\Traits\MigrationDataTypeDestructTrait;

/**
 * Class DateTimeMigrationType
 * @package App\Components\Database\Migration
 */
class DateTimeMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;

    /**
     * @var string
     */
    private string $type='DATETIME';

    /**
     * DateTimeMigrationType constructor.
     * @param string $table
     * @param string $column
     * @param $connectionName
     */
    public function __construct(string $table, string $column, $connectionName)
    {
        $this->length=6;
        $this->table = $table;
        $this->column = $column;
        $this->connectionName = $connectionName;
    }
}
