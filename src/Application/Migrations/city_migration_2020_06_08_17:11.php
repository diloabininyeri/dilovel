<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

/**
 * Class CityCreateMigration
 * @noinspection PhpUnused
 */
class CityCreateMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('cities', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->string('name');
            $table->integer('country_id')->length(3)->comment('country');
            $table->json('response');
            $table->longText('long_about');
            $table->tinyint('status')->default(1);
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('cities');
    }
}
