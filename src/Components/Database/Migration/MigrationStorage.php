<?php


namespace App\Components\Database\Migration;

/**
 * Class MigrationStorage
 * @package App\Components\Database\Migration
 */
class MigrationStorage
{


    /**
     * @var array
     */
    private static array $migrationObjects = [];


    /**
     * @param $table
     * @param $connectionName
     * @param $attributes
     */
    public static function add($table, $connectionName, $attributes)
    {
        static::$migrationObjects[$table][] = [
            'connection_name' => $connectionName,
            'column_name'=>$attributes['column_name'],
            'type'=>$attributes['type'],
            'length' => $attributes['length'],
            'nullable' => $attributes['nullable'],
            'unique' => $attributes['nullable'],
            'auto_increment'=>$attributes['auto_increment'],
            'primary_key'=>$attributes['primary_key'],

        ];
    }

    /**
     * @param string $table
     * @return mixed
     */
    public static function get(string $table)
    {
        return static::$migrationObjects[$table];
    }

    /**
     * @return array
     */
    public static function all()
    {
        return static::$migrationObjects;
    }
}
