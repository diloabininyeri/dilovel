<?php


namespace App\Components\Database\Migration;

class MigrationBuilder
{
    private string $table;

    private string $connectionName;

    public function __construct(string $table, string $connectionName)
    {
        $this->table=$table;
        $this->connectionName=$connectionName;
    }

    public function primaryKey(string $column)
    {
        return new PrimaryKeyMigrationType($this->table, $column, $this->connectionName);
    }

    public function string(string $column)
    {
        return new StringMigrationType($this->table, $column, $this->connectionName);
    }

    public function dateTime(string $column)
    {
    }
}
