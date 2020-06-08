<?php


namespace App\Interfaces;

use App\Components\Database\Migration\MigrationStorage;
use App\Components\Database\Migration\PrimaryKeyMigrationType;

/**
 * Interface MigrationObjectMethodInterface
 * @package App\Interfaces
 */
interface MigrationObjectMethodInterface
{

    /**
     * MigrationObjectMethodInterface constructor.
     * @param string $table
     * @param string $column
     * @param $connectionName
     */
    public function __construct(string $table, string $column, $connectionName);


    /**
     * @return $this
     */
    public function nullable(): self;

    /**
     * @return $this
     */
    public function unique(): self;

    /**
     * @param int $length
     * @return $this
     */
    public function length(int $length): self;

    /**
     * @param $default
     * @return $this
     */
    public function default($default):self;

    /**
     * @param string $comment
     * @return $this
     */
    public function comment(string $comment):self;

    /**
     *
     */
    public function __destruct();
}
