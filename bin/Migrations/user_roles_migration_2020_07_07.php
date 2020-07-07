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
class UserRolesMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('user_roles', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->integer('user_id')->nullable();
            $table->integer('role_id')->nullable();
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('user_roles');
    }
}
