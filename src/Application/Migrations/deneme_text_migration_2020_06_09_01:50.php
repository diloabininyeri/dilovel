<?php

/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

/**
 * Class Deneme_textCreateMigration
 * @noinspection PhpUnused
 */
class Deneme_textCreateMigration implements MigrationInterface
{
    public function create():void
    {
        Schema::connection('default')->create('deneme_text', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->smallInt('deneme_small_int');
            $table->tinyText('tiny_text_deneme');
            $table->boolean('status')->default(1);
            $table->mediumText('medium_text_deneme');
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop():void
    {
        Schema::connection('default')->drop('deneme_text');
    }
}
