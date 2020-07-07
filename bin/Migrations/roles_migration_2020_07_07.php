<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/


use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

/**
 * Class RoleMigration
 * @noinspection PhpUnused
 */
class RoleMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('roles', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->string('name')->unique();
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('roles');
    }
}
