<?php


namespace App\Interfaces;

use App\Components\Database\BuilderQuery;

/**
 * Interface HasRelationInterface
 * @package App\Interfaces
 */
interface HasRelationInterface
{
    /**
     * @param BuilderQuery $builderQuery
     * @return BuilderQuery
     */
    public function setHasExistQuery(BuilderQuery $builderQuery): BuilderQuery;
}
