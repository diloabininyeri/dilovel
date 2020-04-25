<?php


namespace App\app\Models;


use App\Components\Database\Model;

/**
 * Class Book
 * @package App\app\Models
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
    protected array $hidden = ['name'];


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