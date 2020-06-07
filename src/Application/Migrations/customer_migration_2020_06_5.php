<?php


/**
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpIllegalPsrClassPathInspection
 **/

use App\Components\Database\Migration\MigrationBuilder;
use App\Components\Database\Migration\Schema;
use App\Interfaces\MigrationInterface;

class customerMigration2020065 implements MigrationInterface
{
    public function create(): void
    {
        Schema::connection('default')->create('customers', static function (MigrationBuilder $migration) {
            $migration->primaryKey('id')->length(100)->unique();
            $migration->string('customer_name')->nullable();
            $migration->string('city_id');
            $migration->dateTime('date');
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
