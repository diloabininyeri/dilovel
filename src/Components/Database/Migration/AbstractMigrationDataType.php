<?php


namespace App\Components\Database\Migration;

use App\Interfaces\MigrationObjectMethodInterface;

abstract class AbstractMigrationDataType implements MigrationObjectMethodInterface
{

    /**
     * @var string $column
     */
    protected string $column;

    /**
     * @var string $table
     */
    protected string $table;

    /**
     * @var string $connectionName
     */
    protected string $connectionName;

    /**
     * @var bool $isUnique
     */
    protected bool $isUnique = false;

    /**
     * @var bool $isNullable
     */
    protected bool  $isNullable = false;

    /**
     * @var int $length
     */
    protected int $length=45;


    /**
     * @var string|null
     */
    protected ?string $default=null;

    /**
     * @var string|null
     */
    protected ?string $comment=null;
    /**
     * @return $this
     */
    public function nullable(): self
    {
        $this->isNullable=true;
        return $this;
    }

    /**
     * @return $this
     */
    public function unique(): self
    {
        $this->isUnique=true;
        return $this;
    }

    /**
     * @param $default
     * @return $this
     */
    public function default($default):self
    {
        $this->default=$default;
        return $this;
    }

    public function comment(string $comment):self
    {
        $this->comment=$comment;
        return $this;
    }
    /**
     * @param int $length
     * @return $this
     */
    public function length(int $length): self
    {
        $this->length=$length;
        return $this;
    }
}
