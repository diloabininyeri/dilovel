<?php


namespace App\Components\Database\Migration;

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
            'length' => $this->length,
            'unique' => $this->isUnique

        ]);
    }
}
