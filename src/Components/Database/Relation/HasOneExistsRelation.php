<?php


namespace App\Components\Database\Relation;

use App\Components\Database\BuilderQuery;

/**
 * Class HasOneRelation
 * @package App\Components\Database\Relation
 */
class HasOneExistsRelation
{

    /**
     * @var HasOne
     */
    private HasOne $hasOne;

    /**
     * HasOneRelation constructor.
     * @param HasOne $hasOne
     */
    public function __construct(HasOne $hasOne)
    {
        $this->hasOne = $hasOne;
    }

    /**
     * @param BuilderQuery $builderQuery
     * @return BuilderQuery
     */
    public function setHasExistQuery(BuilderQuery $builderQuery): BuilderQuery
    {
        $relationTable = $this->hasOne->getBuilderQuery()->getTable();
        $table = $builderQuery->getTable();
        $foreignKey = $this->hasOne->getForeignKey();
        $primaryKey = $this->hasOne->getPrimaryKey();
        $features = compact('relationTable', 'table', 'foreignKey', 'primaryKey');

        if ($builderQuery->isWhereUsed()) {
            return $this->setQueryWithoutWhere($builderQuery, $features);
        }
        return $this->setQueryWithWhere($builderQuery, $features);
    }

    /**
     * @param BuilderQuery $builderQuery
     * @param array $features
     * @return BuilderQuery
     */
    private function setQueryWithWhere(BuilderQuery $builderQuery, array $features): BuilderQuery
    {
        $sql="{$builderQuery->getSelectQuery()} FROM {$features['table']}  WHERE EXISTS (SELECT * FROM  {$features['relationTable']} WHERE {$features['relationTable']}.{$features['foreignKey']}={$features['table']}.{$features['primaryKey']}) {$builderQuery->getOrderBy()} {$builderQuery->getLimitQuery()} ";

        return $builderQuery->setQuery(trim($sql));
    }

    /**
     * @param BuilderQuery $builderQuery
     * @param array $features
     * @return BuilderQuery
     */
    private function setQueryWithoutWhere(BuilderQuery $builderQuery, array $features): BuilderQuery
    {
        $sql="{$builderQuery->getSelectQuery()} FROM {$features['table']} {$builderQuery->getWhereQuery()} AND EXISTS (SELECT * FROM  {$features['relationTable']} WHERE {$features['relationTable']}.{$features['foreignKey']}={$features['table']}.{$features['primaryKey']})  {$builderQuery->getOrderBy()} {$builderQuery->getLimitQuery()}";
        return $builderQuery->setQuery(trim($sql));
    }
}
