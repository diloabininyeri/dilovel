<?php


namespace App\Interfaces;

/**
 * Interface RelationInterface
 * @package App\Interfaces
 */
interface RelationInterface
{
    /**
     * @param array $records
     * @param string $relation
     * @return array
     */
    public function getWithRelation(array $records, string $relation): array;
}
