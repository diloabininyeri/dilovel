<?php


namespace App\Components\Database\Migration;


/**
 * Class IntegerMigrationType
 * @package App\Components\Database\Migration
 */
class IntegerMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;

    /**
     * @var string
     */
    private string $type='INTEGER';

    /**
     * IntegerMigrationType constructor.
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