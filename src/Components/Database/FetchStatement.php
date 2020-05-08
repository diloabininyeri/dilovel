<?php


namespace App\Components\Database;

use PDO;
use PDOStatement;

/**
 * Class Execute
 * @package App\Components\Database
 */
class FetchStatement
{
    /**
     * @var string
     */
    private string $query;

    /**
     * @var string
     */
    private string  $modelClass;

    /**
     * @var array
     */
    private array $bindArray;

    /**
     * @var PDO $pdo
     */
    private PDO $pdo;

    /**
     * @var BuilderQuery $builderQuery
     */
    private BuilderQuery $builderQuery;

    /**
     * @param string $query
     * @return FetchStatement
     */
    public function setQuery(string $query): FetchStatement
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param string $modelClass
     * @return FetchStatement
     */
    public function setModelClass(string $modelClass): FetchStatement
    {
        $this->modelClass = $modelClass;
        return $this;
    }

    /**
     * @param array $bindArray
     * @return FetchStatement
     */
    public function setBindArray(array $bindArray): FetchStatement
    {
        $this->bindArray = $bindArray;
        return $this;
    }

    /**
     * @return string
     */
    private function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    private function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * @return array
     */
    private function getBindArray(): array
    {
        return $this->bindArray;
    }

    /**
     * @return bool|PDOStatement
     */
    private function runQuery()
    {
        $query = $this->getPdo()->prepare($this->getQuery());
        $query->setFetchMode(PDO::FETCH_CLASS, $this->getModelClass());
        $query->execute($this->getBindArray());
        return $query;
    }


    /**
     * @return mixed
     */
    public function fetch()
    {
        return $this->runQuery()->fetch();
    }


    /**
     * @return array|null
     */
    public function fetchAll(): ?array
    {
        return $this->runQuery()->fetchAll();
    }

    /**
     * @param PDO $pdo
     * @return FetchStatement
     */
    public function setPdo(PDO $pdo): FetchStatement
    {
        $this->pdo = $pdo;
        return $this;
    }

    /**
     * @param BuilderQuery $builderQuery
     * @return FetchStatement
     */
    public function setBuilderQuery(BuilderQuery $builderQuery): FetchStatement
    {
        $this->builderQuery = $builderQuery;
        return $this;
    }

    /**
     * @return BuilderQuery
     */
    public function getBuilderQuery(): BuilderQuery
    {
        return $this->builderQuery;
    }

    /**
     * @return PDO
     */
    private function getPdo(): PDO
    {
        return $this->pdo;
    }
}
