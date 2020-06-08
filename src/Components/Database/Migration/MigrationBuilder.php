<?php


namespace App\Components\Database\Migration;

/**
 * Class MigrationBuilder
 * @package App\Components\Database\Migration
 */
class MigrationBuilder
{
    /**
     * @var string $table
     */
    private string $table;

    /**
     * @var string $connectionName
     */
    private string $connectionName;

    /**
     * MigrationBuilder constructor.
     * @param string $table
     * @param string $connectionName
     */
    public function __construct(string $table, string $connectionName)
    {
        $this->table = $table;
        $this->connectionName = $connectionName;
    }

    /**
     * @param string $column
     * @return PrimaryKeyMigrationType
     */
    public function primaryKey(string $column): PrimaryKeyMigrationType
    {
        return new PrimaryKeyMigrationType($this->table, $column, $this->connectionName);
    }

    /**
     * @param string $column
     * @return StringMigrationType
     */
    public function string(string $column): StringMigrationType
    {
        return new StringMigrationType($this->table, $column, $this->connectionName);
    }

    /**
     * @param string $column
     * @return DateTimeMigrationType
     */
    public function dateTime(string $column):DateTimeMigrationType
    {
        return new DateTimeMigrationType($this->table, $column, $this->connectionName);
    }

    /**
     * @param string $column
     * @return TextMigrationType
     */
    public function text(string $column): TextMigrationType
    {
        return new TextMigrationType($this->table, $column, $this->connectionName);
    }

    /**
     * @param string $column
     * @return IntegerMigrationType
     */
    public function integer(string $column): IntegerMigrationType
    {
        return new IntegerMigrationType($this->table, $column, $this->connectionName);
    }

    /**
     * @return TimeStampMigrationType
     */
    public function timestamp():TimeStampMigrationType
    {
        return new TimeStampMigrationType($this->table,  $this->connectionName);
    }
}
