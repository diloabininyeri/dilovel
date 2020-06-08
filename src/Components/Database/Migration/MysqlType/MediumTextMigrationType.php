<?php


namespace App\Components\Database\Migration\MysqlType;

use App\Components\Database\Migration\AbstractMigrationDataType;
use App\Components\Database\Traits\MigrationDataTypeDestructTrait;

/**
 * Class MediumTextMigrationType
 * @package App\Components\Database\Migration\MysqlType
 */
class MediumTextMigrationType extends AbstractMigrationDataType
{
    use MigrationDataTypeDestructTrait;


    /**
     * @var string
     */
    private string $type = 'MEDIUMTEXT';

    /**
     * MediumTextMigrationType constructor.
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
