<?php


namespace App\Components\Database\Migration;

use App\Interfaces\MigrationObjectMethodInterface;

/**
 * Class PrimaryKeyMigrationType
 * @package App\Components\Database\Migration
 */
class PrimaryKeyMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;

    private string $type='INTEGER';

    /**
     * @var bool $isAutoIncrement
     */
    private bool $isAutoIncrement=true;

    /**
     * @var bool $isPrimaryKey
     */
    private bool $isPrimaryKey=true;
    /**
     * PrimaryKeyMigrationType constructor.
     * @param string $table
     * @param string $column
     * @param $connectionName
     */
    public function __construct(string $table, string $column, $connectionName)
    {
        $this->column = $column;
        $this->table = $table;
        $this->connectionName = $connectionName;
    }
}
