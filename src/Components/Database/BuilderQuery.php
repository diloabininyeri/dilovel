<?php

namespace App\Components\Database;

use App\Components\Collection\Collection;
use PDO;

/**
 * Class BuilderQuery
 * @package App\Database
 */
class BuilderQuery
{
    /**
     * @var Model
     */
    private Model $modelInstance;

    /**
     * @var PDO
     */
    private PDO $pdo;

    private ?string $query = null;

    private bool  $activeToSql;

    /**
     * BuilderQuery constructor.
     * @param Model $model
     * @param PDO $pdo
     */
    public function __construct(Model $model, PDO $pdo)
    {
        $this->modelInstance = $model;
        $this->pdo = $pdo;
    }

    public function where($key, $operartor, $value)
    {
        return 'mera-haba';
    }

    private function getTable()
    {
        return $this->modelInstance->getTable();
    }


    /**
     * @return array
     */
    public function get()
    {
        $table = $this->modelInstance->getTable();
        return $this->run("select * from  $table " . $this->getQuery());
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $table = $this->getTable();
        $stmt = $this->pdo->prepare("select * from $table where id=:id");
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->modelInstance->getStaticClass());
        $stmt->execute([$this->modelInstance->getPrimaryKey() => $id]);
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function findOrFail($id)
    {
        return $this->find($id) ?: abort(404);
    }

    /**
     * @param $query
     * @param array $execute
     * @return Collection|array
     */
    private function run($query, $execute = [])
    {
        if (empty($execute)) {
            $result = $this->pdo->query($query)->fetchAll(PDO::FETCH_CLASS, $this->modelInstance->getStaticClass());
            if ($this->modelInstance->getHidden()) {
                $this->unsetHiddenProperties($result);
            }
            return new Collection($result);
        }
        return [];
    }

    /**
     * @param $result
     */
    private function unsetHiddenProperties($result): void
    {
        $hidden = $this->modelInstance->getHidden();
        array_map(static function ($object) use ($hidden) {
            if ($hidden) {
                foreach ($hidden as $property) {
                    unset($object->$property);
                }
            }
        }, $result);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $name = sprintf('scope%s', ucfirst($name));
        if (method_exists($this->modelInstance, $name)) {
            return $this->modelInstance->$name($this);
        }
        return $this;

    }

    /**
     * @return $this
     */
    public function orderByAsc()
    {
        $this->setQuery('order by id desc ');
        return $this;
    }

    /**
     * @param mixed $query
     * @return BuilderQuery
     */
    private function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return mixed
     */
    private function getQuery()
    {
        return $this->query;
    }


    public function activateToSql()
    {
        return $this->isActiveToSql();
    }

    /**
     * @return bool
     */
    private function isActiveToSql(): bool
    {
        return $this->activeToSql;
    }

    /**
     * @param bool $activeToSql
     */
    private function setActiveToSql(bool $activeToSql): void
    {
        $this->activeToSql = $activeToSql;
    }


    public function save()
    {
        return get_object_vars($this->modelInstance);
    }

}