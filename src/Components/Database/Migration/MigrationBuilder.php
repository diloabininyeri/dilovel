<?php


namespace App\Components\Database\Migration;

class MigrationBuilder
{

    private string $table;

    private string $connectionName;

    public function __construct(string $table,string $connectionName)
    {
        $this->table=$table;
        $this->connectionName=$connectionName;
    }

    public function primaryKey(string $column)
    {

    }

    public function string(string $column)
    {
    }

    public function dateTime(string $column)
    {
    }
}
