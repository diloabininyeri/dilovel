<?php


namespace App\Components\Database\Migration;

use App\Components\Database\PDOAdaptor;

/**
 * Class Migration
 * @package App\Components\Database\Migration
 */
class Migration
{
    /**
     * @var array
     */
    private array $migrationAttributes;

    /**
     * @var string
     */
    private string $path = 'bin/Migrations/*.php';


    public function __construct()
    {
        $this->migrationAttributes = MigrationStorage::all();
    }

    /**
     * @return array
     */
    public function getPaths(): array
    {
        return glob($this->path);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->migrationAttributes;
    }
}
