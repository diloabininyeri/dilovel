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
        Schema::connection('default')->create('peoples',function (MigrationBuilder $migration){

            $migration->primaryKey('id');
            $migration->string('name');
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
