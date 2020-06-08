<?php


namespace App\Components\Database\Traits;

use App\Components\Database\Migration\MigrationStorage;

trait MigrationDataTypeDestructTrait
{
    /**
     *
     */
    public function __destruct()
    {
        MigrationStorage::add($this->table, $this->connectionName, [
            'column_name' => $this->column,
            'type'=>$this->type,
            'nullable' => $this->isNullable,
            'length' => $this->length ?? null,
            'unique' => $this->isUnique,
            'auto_increment'=>$this->isAutoIncrement ?? false,
            'primary_key'=>$this->isPrimaryKey ?? false,
            'default'=>$this->default,
            'comment'=>$this->comment

        ]);
    }
}
