<?php


namespace App\Interfaces;

/**
 * Interface MigrationInterface
 * @package App\Interfaces
 */
interface MigrationInterface
{

    /**
     *
     */
    public function create(): void;

    /**
     *
     */
    public function drop(): void;
}
