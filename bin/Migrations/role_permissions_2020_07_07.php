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
class RolePermissions implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('role_permissions', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->integer('permission_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('role_permissions');
    }
}
