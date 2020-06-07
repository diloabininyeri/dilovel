<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

class ExampleMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('peoples', static function (MigrationBuilder $migration) {
            $migration->primaryKey('id')->length(100)->unique();
            $migration->string('name')->nullable();
            $migration->string('surname');
            $migration->dateTime('date');
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('peoples');
    }
}
