<?php

namespace App\Components\Database;

use App\Components\Database\Relation\BelongsTo;
use App\Components\Database\Relation\BelongsToMany;
use App\Components\Database\Relation\HasMany;
use App\Components\Database\Relation\HasOne;
use Carbon\Carbon;
use JsonException;

/**
 * Class Model
 * @package App\Models
 * @property string $created_at
 * @property string $updated_at
 */
abstract class Model
{
    protected string $connection = 'default';
    /**
     * @var BuilderQuery
     */
    private BuilderQuery $builderQuery;

    /**
     * @var string|null
     */
    private static ?string $observeClass = null;


    /**
     * @var int|null
     */
    private ?int $cacheTime=null;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->builderQuery = new BuilderQuery($this);
    }

    /**
     * @param string $class
     */
    final public static function observe(string $class): void
    {
        self::$observeClass = $class;
    }

    /**
     * @return string
     */
    final public function getObserveClass(): ?string
    {
        return self::$observeClass;
    }

    /**
     * @return mixed
     * @throws JsonException
     */
    final public function toArray()
    {
        return object_to_array($this);
    }

    /**
     * @return mixed
     */
    final public function getTable(): string
    {
        return $this->table ?? $this->getStaticClassName();
    }

    /**
     * @return array
     */
    final public function getHidden(): array
    {
        return $this->hidden ?? [];
    }


    /**
     * @return string
     */
    private function getStaticClassName(): string
    {
        $modelName = substr(strrchr(static::class, "\\"), 1);
        return strtolower($modelName);
    }

    /**
     * @return string
     */
    final public function getStaticClass(): string
    {
        return static::class;
    }

    /**
     * @param string $connectionName
     * @return $this
     */
    public function setConnection(string $connectionName): self
    {
        $this->connection = $connectionName;
        return $this;
    }

    /**
     * @return string
     */
    final public function getConnection(): string
    {
        return $this->connection ?? 'default';
    }

    /**
     * @return array
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function objectableProperties(): array
    {
        return $this->objectable ?? [];
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    final public function __call($name, $arguments)
    {
        sscanf($name, 'get%s', $property);
        $property = strtolower($property);
        if (array_key_exists($property, $this->objectableProperties())) {
            $objectAbleClass = $this->objectableProperties()[$property];
            return new $objectAbleClass($this->$property);
        }

        return $this->builderQuery->$name(...$arguments);
    }


    /**
     * @return int|null
     */
    final public function getCacheTime():?int
    {
        return $this->cacheTime ?? null;
    }

    /**
     * @param int $seconds
     * @return $this
     */
    final public function setCacheTime(int $seconds):self
    {
        $this->cacheTime=$seconds;
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    final public static function __callStatic($name, $arguments)
    {
        $model = new static();
        if (method_exists($model, 'onConstruct')) {
            $model->onConstruct();
        }
        return $model->$name(...$arguments);
    }

    /**
     * @param $name
     */
    final public function __isset($name)
    {
        // TODO: Implement __isset() method.
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    final public function __set($name, $value)
    {
        $setMethod = 'set' . ucfirst($name) . 'Attribute';

        if (method_exists($this, $setMethod)) {
            return $this->$name = $this->$setMethod($value);
        }
        return $this->$name = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    final public function __get($name)
    {
        $method = 'getDefault' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (method_exists($this, $name)) {
            return $this->$name();
        }
        return null;
    }

    /**
     * @param string $relationClass
     * @param string $foreignKey
     * @param string $key
     * @return HasOne
     */
    final protected function hasOne(string $relationClass, string $foreignKey, string $key = 'id'): HasOne
    {
        return (new HasOne($relationClass))
            ->setForeignKey($foreignKey)
            ->setPrimaryKey($key)
            ->setModel($this)
            ->build();
    }

    /**
     * @param string $relationClass
     * @param string $foreignKey
     * @param string $primaryKey
     * @return HasMany
     */
    final protected function hasMany(string $relationClass, string $foreignKey, string $primaryKey = 'id'):HasMany
    {
        return (new HasMany($relationClass))
            ->setForeignKey($foreignKey)
            ->setPrimaryKey($primaryKey)
            ->setModel($this)
            ->build();
    }


    /**
     * @param string $relationClass
     * @param string $foreignKey
     * @param string $primaryKey
     * @return BelongsTo
     */
    final protected function belongsTo(string $relationClass, string $foreignKey, string $primaryKey = 'id'):BelongsTo
    {
        return (new BelongsTo($relationClass))
            ->setForeignKey($foreignKey)
            ->setPrimaryKey($primaryKey)
            ->setModel($this)
            ->build();
    }

    /**
     * @param string $relationClass
     * @param string $table
     * @param string $relationForeignKey
     * @param string $foreignKey
     * @return BelongsToMany
     */
    final protected function belongsToMany(string $relationClass, string $table, string $relationForeignKey, string $foreignKey):BelongsToMany
    {
        return (new BelongsToMany($relationClass))
            ->setModel($this)
            ->setRelationForeignKey($relationForeignKey)
            ->setForeignKey($foreignKey)
            ->setTable($table)
            ->build();
    }
    /**
     * @return mixed|string
     */
    final public function getPrimaryKey()
    {
        return $this->primaryKey ?? 'id';
    }

    /**
     * @return mixed|null
     */
    final public function isPrimaryKeyHasValue()
    {
        return $this->getPrimaryKeyValue();
    }

    /**
     * @return mixed|null
     */
    final public function getPrimaryKeyValue()
    {
        $primaryKey = $this->getPrimaryKey();
        return $this->$primaryKey;
    }

    /**
     * @param null $lang
     * @return string
     */
    final public function createdDate($lang = null): string
    {
        if ($lang !== null) {
            now()->setLocal($lang);
        }
        return now()->diffForHumans($this->created_at);
    }

    /**
     * @param null $lang
     * @return string
     */
    final public function updatedDate($lang = null): string
    {
        if ($lang !== null) {
            now()->setLocal($lang);
        }
        return now()->diffForHumans($this->updated_at);
    }

    /**
     * @return array
     */
    final public function getFilterableFields(): array
    {
        return $this->filterable ?? $this->builderQuery->columnNames();
    }

    /**
     * @param array $default
     * @return $this
     */
    final public function withDefault(array $default): self
    {
        foreach ($default as $key => $value) {
            if ($this->$key === null) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    /**
     * @param string $attribute
     * @param callable $callable
     * @return $this
     */
    final public function setAttribute(string $attribute, callable $callable): self
    {
        $this->$attribute = $callable($this->$attribute);
        return $this;
    }

    /**
     * @return $this
     */
    final public function toDiffForHumans(): self
    {
        $this->created_at = Carbon::parse($this->created_at)->diffForHumans();
        $this->updated_at = Carbon::parse($this->updated_at)->diffForHumans();
        return $this;
    }

    /**
     * @param $oldName
     * @param $newName
     * @param bool $delete
     * @return $this
     */
    public function renameAttribute($oldName, $newName, $delete = true): self
    {
        $this->$newName = $this->$oldName;
        if ($delete) {
            unset($this->$oldName);
        }
        return $this;
    }

    /**
     * @return object
     * @throws JsonException
     */
    public function getAttributes(): object
    {
        return (object)$this->toArray();
    }
}
