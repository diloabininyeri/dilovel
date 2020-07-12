<?php


namespace App\Application\Models;

use App\Components\Database\BuilderQuery;
use App\Components\Database\Model;

/**
 * Class Book
 * @package App\app\Models
 * @mixin BuilderQuery
 * @method static BuilderQuery|Users find(int $id)
 */
class Book extends Model
{

    /**
     * @var string
     */
    protected string $table = 'books';

    /**
     * @var string
     */
    protected string $connection = 'default';


    /**
     * @var array|string[]
     */
    protected array $hidden = [];


    /**
     * @return string
     */
    public function getBookName()
    {
        return strtoupper($this->name);
    }

    /**
     * @return string
     */
    public function getDefaultName()
    {
        return 'no names';
    }
}
