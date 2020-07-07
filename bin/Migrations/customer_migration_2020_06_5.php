<?php


/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

/**
 * Class customerMigration2020065
 * @noinspection PhpUnused
 */
class customerMigration2020065 implements MigrationInterface
{
    public function create(): void
    {
        Schema::connection('default')->create('customers', static function (MigrationBuilder $table) {
            $table->primaryKey('id')->length(100)->unique();
            $table->integer('city_id');
            $table->string('customer_name')->nullable();
            $table->text('about');
            $table->timestamp();
        });
    }


    /**
     * @throws Exception
     */
    public function drop(): void
    {
        Schema::connection('default')->drop('customers');
    }
}
