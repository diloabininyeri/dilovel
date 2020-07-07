<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

class User_permissionCreateMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('user_permissions', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->integer('permission_id');
            $table->integer('user_id');
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('user_permissions');
    }
}
