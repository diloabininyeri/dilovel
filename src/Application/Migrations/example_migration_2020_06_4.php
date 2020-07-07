<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

/**
 * Class ExampleMigration
 * @noinspection PhpUnused
 */
class ExampleMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('peoples', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->string('name')->nullable();
            $table->string('surname')->comment('surname foo bar comment');
            $table->dateTime('date');
            $table->timestamp();
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
